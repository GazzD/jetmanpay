<?php
namespace app\Http\Controllers;

use App\Client;
use App\Payment;
use App\Plane;
use App\Dosa;
use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\PaymentItem;

class PaymentsController extends Controller
{

    public function indexPending()
    {
        $clients = Client::all();
        return view('pages.backend.payments.index-pending')->with('clients', $clients);
    }

    public function fetchPending(Request $request)
    {
        // Datatable functionality (pagination, filter, order)
        return $this->getPayments(true);
    }

    public function indexCompleted()
    {
        $clients = Client::all();
        return view('pages.backend.payments.index-completed')->with('clients', $clients);
    }

    public function fetchCompleted(Request $request)
    {
        // Datatable functionality (pagination, filter, order)
        return $this->getPayments(false);
    }

    public function manual(Request $request)
    {
        // Opens a form to create AND pay directly an invoice
        $planes = Plane::all();
        return view('pages.backend.payments.manual-payment')->with('planes', $planes);
    }

    public function storeManual(Request $request)
    {
        // Creates a new payment and approves it
        $planeId = $request->planeId + 0;
        $clientId = $request->clientId + 0;
        $currency = $request->currency;
        $reference = $request->reference;
        $description = $request->description;
        $paymentItemList = $request->feeList;
        $totalAmount = 0;
        $userId = Auth::user()->id;

        // Calculating total amount
        foreach ($paymentItemList as $paymentItemArray) {
            $totalAmount = $totalAmount + $paymentItemArray['amount'];
        }

        $payment = new Payment();
        $payment->invoice_number = $this->generetateInvoiceNumber();
        $payment->plane_id = $planeId;
        $payment->client_id = $clientId;
        $payment->user_id = $userId;
        $payment->currency = $currency;
        $payment->number = 'ISP-' . $this->generateRandomString();
        $payment->reference = $reference;
        $payment->description = $description;
        $payment->status = 'APPROVED';
        $payment->total_amount = $totalAmount;
        $payment->dosa_date = date('Y-m-d H:i:s');
        $payment->save();

        foreach ($paymentItemList as $paymentItemArray) {
            $paymentItem = new PaymentItem();
            $paymentItem->concept = $paymentItemArray['concept'];
            $paymentItem->amount = $paymentItemArray['amount'];
            $paymentItem->payment_id = $payment->id;
            $paymentItem->save();
        }

        return $payment;
    }

    public function receipt($id)
    {
        // Get payment
        $payment = Payment::with('items')->with('client')
            ->with('plane')
            ->find($id);

        $color = '#FFF';
        switch ($payment->status) {
            case 'APPROVED':
                $color = '#65FF3A';
                break;
            case 'REJECTED':
            case 'CANCELLED':
                $color = '#FF2600';
                break;
            case 'PENDING':
                $color = '#FF9544';
                break;
        }
        $currency = 'x';
        switch ($payment->currency) {
            case 'USD':
                $currency = '$';
                break;
            case 'VEF':
                $currency = 'BsS';
                break;
        }

        // Calculate taxes
        $tax = 0;
        $subtotal = 0;
        $appfee = 0;
        foreach ($payment->items as $item) {
            $tax += $item->fee;
            $subtotal += $item->amount - $item->fee;
        }

        $data = [
            'payment' => $payment,
            'color' => $color,
            'currency' => $currency,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'appfee' => $appfee
        ];

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->loadView('pdf.payment-receipt', $data)->download('IPS Bill receipt.pdf');
    }

    public function filterByPlane()
    {
        // Opens a view with all planes to futher filter pending payments
        return view('pages.backend.payments.select-list');
    }

    public function pendingPaymentsByPlane(Request $request)
    {
        switch (auth()->user()->getRoleNames()[0]) {
            case 'MANAGER':
                // Opens a view with all pending payments from a plane id
                $planeTail = $request->planeTail;
                $payments = Payment::where('status', 'PENDING')->whereHas('plane', function ($q) use ($planeTail) {
                    $q->where('tail_number', $planeTail);
                })
                    ->with('client')
                    ->get();
                break;
            case 'OPERATOR':
                // Opens a view with all pending payments made by that operator from a plane id
                $planeTail = $request->planeTail;
                $payments = Payment::where('status', 'PENDING')->where('user_id', auth()->user()->id)
                    ->whereHas('plane', function ($q) use ($planeTail) {
                    $q->where('tail_number', $planeTail);
                })
                    ->with('client')
                    ->get();
                break;
            case 'CLIENT':
                // Opens a view with all pending payments made by that operator from a plane id
                $planeTail = $request->planeTail;
                $payments = Payment::where('status', 'PENDING')->where('client_id', auth()->user()->client_id)
                    ->whereHas('plane', function ($q) use ($planeTail) {
                    $q->where('tail_number', $planeTail);
                })
                    ->with('client')
                    ->get();
                break;

            default:
                $payments = [];
                break;
        }

        if ($payments->count() == 0) {
            return redirect()->route('payments/filter/plane')->withErrors(Lang::get('validation.payments.plane_not_found_or_pending'));
        }
        return view('pages.backend.payments.filter-pending')->with('payments', $payments);
    }

    public function createPayment(Request $request)
    {
        dd('xxxx');
        // Creates a payment based on dosas
        $dosaIds = $request->dosaIds;
        // dump($dosaIds);
        $reference = $request->reference;
        $description = $request->description;
        $planeId = $request->planeId;
        $tax = $this->getTaxes(); // 15 %
        $taxMultiplier = ($tax / 100) + 1; // 1.15
        $user = auth()->user();

        $dosas = Dosa::where('client_id', $user->client_id)->where('status', 'PENDING')
            ->whereIn('id', $dosaIds)
            ->get();
        // dd($dosas);
        $plane = Plane::find($dosas[0]->plane_id);
        $client = Client::find($user->client_id);
        $totalAmount = 0;
        foreach ($dosas as $dosa) {
            $conversionRate = $this->getConversionRate($dosa->currency, $client->currency);
            $dosa->convertedAmount = $dosa->total_dosa_amount * $conversionRate;
            $totalAmount = $totalAmount + ($dosa->convertedAmount);
        }

        $taxAmount = $totalAmount * ($taxMultiplier - 1);
        $totalAmount = $totalAmount * $taxMultiplier;

        $payment = new Payment();
        $payment->client_id = $client->id;
        $payment->user_id = $user->id;
        $payment->reference = $reference;
        $payment->description = $description;
        $payment->total_amount = $totalAmount;
        $payment->currency = $client->currency;
        $payment->plane_id = $plane->id;
        $payment->number = 'ISP-' . $this->generateRandomString();
        $payment->dosa_date = date('Y-m-d');
        $payment->invoice_number = time();
        $payment->dosa_number = $this->generateRandomString();
        if ($user->hasRole('CLIENT')) {
            $payment->status = 'APPROVED';
            if ($client->balance >= $totalAmount) {
                $client->balance = $client->balance - $totalAmount;
                $client->save();
            } else {
                return redirect()->back()->withErrors(Lang::get('messages.dosa.insufficient-balance'));
            }
        } elseif ($user->hasRole('TREASURER1')) {
            $payment->status = 'REVISED1';
        } elseif ($user->hasRole('TREASURER2')) {
            $payment->status = 'REVISED2';
        }
        $payment->save();

        foreach ($dosas as $dosa) {
            $paymentItem = new PaymentItem();
            $paymentItem->concept = $dosa->aperture_code;
            $paymentItem->amount = $dosa->convertedAmount;
            $paymentItem->payment_id = $payment->id;
            $paymentItem->save();
            $newDosa = Dosa::find($dosa->id);
            $newDosa->status = 'APPROVED';
            $newDosa->save();
        }

        return redirect()->route('payments');
    }

    public function payCreated(Request $request, $paymentId)
    {
        // Edit pending payment to change it's satus to APPROVED
        $reference = $request->reference;
        $clientId = $request->clientId;
        $description = $request->description;
        $payment = Payment::find($paymentId);

        $client = Client::find($clientId);
        if ($client->balance < $payment->total_amount) {
            return redirect()->back()->withErrors(Lang::get('validation.payments.not_enough_money'));
        }

        $payment->reference = $reference;
        $payment->description = $description;
        $payment->status = 'APPROVED';
        $payment->save();

        $client->balance = $client->balance - $payment->total_amount;
        $client->save();

        return redirect()->route('payments');
    }

    public function createPayByAirplane(Request $request, $paymentId)
    {
        $payment = Payment::where('id', $paymentId)->with('client')
            ->with('items')
            ->first();
        $taxes = 0;
        foreach ($payment->items as $item) {
            $taxes = $taxes + $item->fee;
        }
        $payment->taxes = $taxes;
        $payment->subTotal = $payment->total_amount - $taxes;
        return view('pages.backend.payments.pay-existing')->with('payment', $payment);
    }

    public function generateReport(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $clientId = $request->clientId;
        $currency = $request->currency;
        $status = $request->status;
        $excelToggle = $request->excelToggle; // If on = Excel, if null = PDF
        $client = Client::find($clientId);
        $user = auth()->user();

        // Filter by role
        switch ($user->getRoleNames()[0]) {
            case 'MANAGER':
                $payments = Payment::where('dosa_date', '>=', $from)
                    ->where('dosa_date', '<=', $to)
                ;
                break;
            case 'OPERATOR':
                $payments = Payment::where('dosa_date', '>=', $from)
                    ->where('dosa_date', '<=', $to)
                    ->where('user_id', $user->id)
                ;
                break;
            case 'CLIENT':
                $payments = Payment::where('dosa_date', '>=', $from)
                    ->where('dosa_date', '<=', $to)
                    ->where('client_id', $user->client_id)
                ;
                break;
            default:
                return redirect()->back();
                break;
        }
        // Filter by selected client (-1 value is all clients)
        if ($clientId != -1) {
            $payments = $payments->where('client_id', $clientId);
        }
        if ($currency != 'ALL') {
            $payments = $payments->where('currency', $currency);
        }
        if ($status != 'ALL') {
            if ($status == 'FINISHED') {
                $payments = $payments->where('status', '!=', 'PENDING');
            } else {
                $payments = $payments->where('status', $status);
            }
        }
        
        // Get payments
        $payments = $payments->with('client')
            ->with('plane')
            ->get()
        ;
        // $payments = Payment::with('plane')->with('client')->get();
        $totalBs = 0;
        $totalUSD = 0;
        foreach ($payments as $payment) {
            if ($payment->currency == 'USD') {
                $totalUSD = $totalUSD + $payment->total_amount;
            } else {
                $totalBs = $totalBs + $payment->total_amount;
            }
            // Calculate amount before commission
            $totalFee = 0;
            foreach ($payment->items as $item) {
                $totalFee = $totalFee + $item->fee;
            }
            $payment->amount_before_commission = $payment->total_amount - $totalFee;
        }
        /*
         * Generate report
         * If excelToggle == null generate PDF, if not, generate excel file
         */
        if (! $excelToggle) {
            // Generate pdf
            $data = [
                'payments' => $payments,
                'from' => $from,
                'to' => $to,
                'client' => $client,
                'now' => date("Y-m-d h:i:sa"),
                'totalUSD' => $totalUSD,
                'totalBs' => $totalBs
            ];

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->loadView('pdf.payments-report', $data)->download('payments-report.pdf');
        } else {
            return Excel::download(new PaymentsExport($from, $to, $clientId, $status, $user, $currency), 'payment-reports-' . $from . '_' . $to . '.xlsx');
        }
    }

    public function details($id)
    {
        $payment = Payment::where('id', $id)->with('plane')
            ->with('items')
            ->with('client')
            ->first();
        return view('pages.backend.payments.details')->with('payment', $payment);
    }

    public function update(Request $request, $id)
    {
        $status = $request->status;
        $payment = Payment::where('id', $id)->with('items')->first();
        $user = auth()->user();
        if ($user->hasRole('CLIENT')) {
            if ($status != 'PENDING' && $status != 'CANCELED') {
                return redirect()->back();
            }
        } elseif ($user->hasRole('TREASURER1')) {
            if ($status != 'REVISED1' && $status != 'CANCELED') {
                return redirect()->back();
            }
        }
        if ($status == 'CANCELED') {
            foreach ($payment->items as $item) {
                $dosa = Dosa::where('aperture_code', $item->concept)->where('client_id', $payment->client_id)->first();
                if ($dosa) {
                    $dosa->status = 'PENDING';
                    $dosa->save();
                }
            }
            $payment->delete();
        } else {
            $payment->status = $status;
            $payment->save();
        }
        return redirect()->route('payments');
    }

    private function generetateInvoiceNumber()
    {
        return time();
    }

    private function getPayments($justPending)
    {
        // Get user role and filter payments acordingly
        switch (auth()->user()->getRoleNames()[0]) {
            case 'MANAGER':
                // All payments
                $query = Payment::with('client')->with('plane')
                    ->with('user')
                    ->with('items')
                    ->latest();
                break;
            case 'OPERATOR':
                // Payments made from that operator
                $query = Payment::where('user_id', auth()->user()->id)->with('client')
                    ->with('plane')
                    ->with('user')
                    ->with('items')
                    ->latest();
                break;
            case 'CLIENT':
                // Payments related to that client
                $query = Payment::where('client_id', auth()->user()->client_id)->with('client')
                    ->with('plane')
                    ->with('user')
                    ->with('items')
                    ->latest();
                break;
            case 'TREASURER1':
                // Payments related to that client
                $query = Payment::where('client_id', auth()->user()->client_id)->with('client')
                    ->with('plane')
                    ->with('user')
                    ->with('items')
                    ->latest();
                break;

            default:
                $query = [];
                break;
        }

        // Validate status
        if ($justPending) {
            switch (auth()->user()->getRoleNames()[0]) {
                case 'MANAGER':
                case 'OPERATOR':
                    $query->where('status', 'PENDING');
                    break;
                case 'CLIENT':
                    $query->where('status', 'PENDING');
                    $query->orwhere('status', 'REVISED1');
                    break;
                case 'TREASURER1':
                    $query->where('status', 'REVISED2');
                    $query->orwhere('status', 'REVISED1');
                    break;
            }
        } else {
            $query->where('status', '<>', 'PENDING');
        }
        // Return datatable
        return DataTables::of($query->get())->addColumn('action', function ($data) {
            $button = '<ul class="fc-color-picker" id="color-chooser">';
            if (auth()->user()
                ->hasRole([
                'TREASURER1',
                'CLIENT'
            ])) {
                $button .= '<li><a class="text-muted" href="' . route('payments/details', $data->id) . '"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('messages.payments.details') . '"></i></a></li>';
            }
            $button .= '<li><a class="text-muted" href="' . route('payment-receipt', $data->id) . '"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="' . __('messages.pending-payments.view-receipt') . '"></i></a></li>';
            $button .= '<li><a class="text-muted" href="' . route('payment-dosa', $data->id) . '"><i class="nav-icon fas fa-file-alt" data-toggle="tooltip" data-placement="top" title="' . __('messages.pending-payments.view-dosa') . '"></i></a></li>';
            $button .= '<li><a class="text-muted" href="' . route('payment-documents', $data->id) . '"><i class="nav-icon far fa-file-alt" data-toggle="tooltip" data-placement="top" title="' . __('messages.pending-payments.view-documents') . '"></i></a></li>';
            $button .= '<li><i class="text-muted fas fa-plus" data-toggle="modal" data-target="#upload-document-' . $data->id . '" data-placement="top" title="' . __('messages.pending-payments.upload-document') . '"></i></li>';
            $button .= '<li><i class="text-muted fas fa-exclamation" data-toggle="modal" data-target="#create-claim-' . $data->id . '" data-placement="top" title="' . __('messages.pending-payments.add-claim') . '"></i></></li>';
            $button .= '</ul>';
            $button .= '<!-- Upload Document Modal -->
                            <div class="modal fade" id="upload-document-' . $data->id . '" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                <!-- form start -->
                                <form role="form" action="' . route('store-payment-documents', $data->id) . '" onsubmit="sendButton.disabled = true;" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">' . __('messages.pending-payments.upload-document') . '</h3>
                                        </div>
                                        <!-- /.box-header -->
                                          ' . csrf_field() . '
                                          <div class="box-body">
                                            <div class="form-group">
                                              <input type="text" required="true" class="form-control" name="name" placeholder="' . __('messages.pending-payments.document-name') . '">
                                            </div>
                                            <div class="form-group">
                                              <input type="file" name="documentFile" />
                                            </div>
                                          </div>
                                          <!-- /.box-body -->
                                            <input type="hidden" name="paymentId" value="' . $data->id . '" />
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">' . __('messages.close') . '</button>
                                    <button type="submit" name="sendButton" class="btn btn-primary">' . __('messages.save') . '</button>
                                  </div>
                                </div>
                                </form>
                              </div>
                            </div>';
            $button .= '<!-- Create claim Modal -->
                            <div class="modal fade" id="create-claim-' . $data->id . '" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                <!-- form start -->
                                <form role="form" action="' . route('claims/store') . '" onsubmit="sendButton.disabled = true;" class="form-horizontal form-label-left" method="post">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">' . __('messages.claims.add_claim') . '</h3>
                                        </div>
                                        <!-- /.box-header -->
                                          ' . csrf_field() . '
                                          <div class="box-body row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <select class="form-control" name="type">
                                                <option value="INCORRECT_AMOUNT">' . __('messages.claims.incorrect_amount') . '</option>
                                                <option value="INCORRECT_FILE">' . __('messages.claims.incorrect_file') . '</option>
                                                <option value="OTHER">' . __('messages.claims.other') . '</option>
                                              </select>
                                            </div>
                                            <div class="col-md-12" style="fñpa">
                                                <div class="form-group">
                                                    <textarea  rows="4" style="width: 100%;" class="from-control" name="description" placeholder="' . __('messages.claims.description') . '"></textarea>
                                                </div>
                                                <div class="loading" style="display:flex; justify-content:center; display:none;">
                                                    <img src="/loading.gif" style="width:50px;" alt="loading"/>
                                                </div>
                                            </div>
                                          </div>
                                          <!-- /.box-body -->
                                            <input type="hidden" name="paymentId" value="' . $data->id . '" />
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">' . __('messages.close') . '</button>
                                    <button type="submit" name="sendButton" class="btn btn-primary submit-claim">' . __('messages.save') . '</button>
                                  </div>
                                </div>
                                </form>
                              </div>
                            </div>';
            return $button;
        })
            ->rawColumns([
            'action'
        ])
            ->make(true);
    }
}

