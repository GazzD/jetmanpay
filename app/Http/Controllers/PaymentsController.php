<?php
namespace app\Http\Controllers;

use App\Client;
use App\Payment;
use App\Plane;
use App\PaymentFee;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Barryvdh\DomPDF\Facade as PDF;

class PaymentsController extends Controller
{
    public function pending()
    {
        return view('pages.backend.pending-payments');
    }
    
    public function payments()
    {
        return view('pages.backend.payments');
    }

    public function json()
    {
        return view('pages.backend.json');
    }

    public function fetchPayments(Request $request)
    {
        // Datatable functionality (pagination, filter, order)
        return $this->getPayments(false); 
    }
    
    public function fetchPendingPayments(Request $request)
    {
        return $this->getPayments(true);
        // Datatable functionality (pagination, filter, order)
    }
    
    public function storeJson(Request $request)
    {
        // Json file name
        $fileName = Str::random(10).'.json';
        
        // Validate json file
        if ($request->hasFile('jsonFile')) {
            // Store json file
            $request->jsonFile->storeAs('public/payments', $fileName);
            
            // Pase json file
            $path = storage_path('app/public/payments/'.$fileName);
            $payments = json_decode(file_get_contents($path), true);
            foreach ($payments as $jsonPayment) {
                // Load payment data
                $client = Client::where('code', $jsonPayment['DOSA']['taxpayer_code'])->first();
                $plane = Plane::where('tail_number', $jsonPayment['DOSA']['tailnumber'])->first();
                $invoiceNumber = $this->generetateInvoiceNumber();
                
                // Create payment
                $payment = new Payment();
                $payment->dosa_number = $jsonPayment['DOSA']['dosa_number'];
                $payment->invoice_number = $invoiceNumber;
                $payment->dosa_date = $jsonPayment['DOSA']['dosa_date'];
                $payment->total_amount = $jsonPayment['DOSA']['total'];
                $payment->plane_id = $plane->id;
                $payment->client_id = $client->id;
                $payment->reference = strtoupper($client->name.' FAC '.$invoiceNumber.' DOSA '. $payment->dosa_number);
                $payment->description = strtoupper($client->name.' FAC '.$invoiceNumber.' DOSA '. $payment->dosa_number);
                $payment->user_id = auth()->user()->id;
                
                // Store payment
                $payment->save();
                
                // Create payment fees
                $paymentFees = array();
                foreach ($jsonPayment['DOSA']['fees'] as $jsonFee) {
                    $paymentFee = [];
                    $paymentFee['old_code'] = $jsonFee['old_code'];
                    $paymentFee['concept'] = $jsonFee['concept'];
                    $paymentFee['amount'] = $jsonFee['amount'];
                    $paymentFee['conversion_fee'] = $jsonFee['conversion_fee'];
                    $paymentFee['payment_id'] = $payment->id;
                    $paymentFee['created_at'] = date('Y-m-d H:i:s');
                    $paymentFee['updated_at'] = date('Y-m-d H:i:s');
                    $paymentFees[] = $paymentFee;
                }
                // Store payment fees
                PaymentFee::insert($paymentFees);
            }
        }
        
        return redirect()->route('load-json')->with('status', __('messages.upload-json.success-message'));
    }

    public function manual(Request $request){
        // Opens a form to create AND pay directly an invoice
        $planes = Plane::all();
        return view('pages.backend.manual-payment')
            ->with('planes',$planes)
        ;
    }
    public function storeManual(Request $request){
        // Creates a new payment and approves it
        
        $planeId = $request->planeId+0;
        $clientId = $request->clientId+0;
        $currency = $request->currency;
        $reference = $request->reference;
        $description = $request->description;
        $feeList = $request->feeList;
        $totalAmount = 0;
        $userId = Auth::user()->id;
        // Calculating total amount
        foreach ($feeList as $feeArray) {
            $totalAmount = $totalAmount + $feeArray['amount'];
        }
        
        $payment = new Payment();
        $payment->invoice_number = $this->generetateInvoiceNumber();
        $payment->plane_id = $planeId;
        $payment->client_id = $clientId;
        $payment->user_id = $userId;
        $payment->currency = $currency;
        $payment->reference = $reference;
        $payment->description = $description;
        $payment->status = 'APPROVED';
        $payment->total_amount = $totalAmount;
        $payment->dosa_date = date('Y-m-d H:i:s');
        $payment->save();
        
        foreach ($feeList as $feeArray) {
            $fee = new PaymentFee();
            $fee->concept = $feeArray['concept'];
            $fee->amount = $feeArray['amount'];
            $fee->payment_id = $payment->id;
            $fee->save();
        }
        
        return $payment;
    }
    
    public function receipt($id) {
        // Get payment
        $payment = Payment::with('fees')->with('client')->with('plane')->find($id);
        
        $color = '#FFF';
        switch($payment->status) {
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
        switch($payment->currency) {
            case 'USD':
                $currency = '$';
                break;
            case 'VEN':
                $currency = 'VEN';
                break;
        }
        
        // Calculate taxes
        $tax = 0;
        $subtotal = 0;
        $appfee = 0;
        foreach ($payment->fees as $fee) {
            $tax += $fee->conversion_fee;
            $subtotal += $fee->amount-$fee->conversion_fee;
        }
        
        $data = [
            'payment' => $payment,
            'color' => $color,
            'currency' => $currency,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'appfee' => $appfee
        ];
        
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        
        return $pdf
            ->loadView('pdf.payment-receipt', $data)
            ->download('IPS Bill receipt.pdf')
        ;
        
    }
    
    private function getPayments($justPending)
    {
        // Build payment query
        $query = Payment::where('user_id', auth()->user()->id)
            ->with('client')
            ->with('plane')
            ->with('user')
            ->with('fees')
            ->latest()
        ;
        
        // Validate status
        if ($justPending) {
            $query->where('status', 'PENDING');
        } else {
            $query->where('status', '<>' ,'PENDING');
        }
        
        // Return datatable
        return DataTables::of($query->get())
        ->addColumn('action', function($data){
            $button = '<ul class="fc-color-picker" id="color-chooser">';
            $button .= '<li><a class="text-muted" href="'.route('payment-receipt', $data->id).'"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="'.__('messages.pending-payments.view-receipt').'"></i></a></li>';
            $button .= '<li><a class="text-muted" href="'.route('payment-dosa', $data->id).'"><i class="nav-icon fas fa-file-alt" data-toggle="tooltip" data-placement="top" title="'.__('messages.pending-payments.view-dosa').'"></i></a></li>';
            $button .= '<li><a class="text-muted" href="'.route('payment-documents', $data->id).'"><i class="nav-icon far fa-file-alt" data-toggle="tooltip" data-placement="top" title="'.__('messages.pending-payments.view-documents').'"></i></a></li>';
            $button .= '<li><i class="text-muted fas fa-plus" data-toggle="modal" data-target="#upload-document-'.$data->id.'" data-placement="top" title="'.__('messages.pending-payments.upload-document').'"></i></li>';
            $button .= '<li><a class="text-muted" href="#"><i class="nav-icon fas fa-exclamation" data-toggle="tooltip" data-placement="top" title="'.__('messages.pending-payments.add-claim').'"></i></a></li>';
            $button .= '</ul>';
            $button .= '<!-- Upload Document Modal -->
                            <div class="modal fade" id="upload-document-'.$data->id.'" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                <!-- form start -->
                                <form role="form" action="'.route('store-payment-documents', $data->id).'" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">'.__('messages.pending-payments.upload-document').'</h3>
                                        </div>
                                        <!-- /.box-header -->
                                          '.csrf_field().'
                                          <div class="box-body">
                                            <div class="form-group">
                                              <input type="text" required="true" class="form-control" name="name" placeholder="'.__('messages.pending-payments.document-name').'">
                                            </div>
                                            <div class="form-group">
                                              <input type="file" name="documentFile" />
                                            </div>
                                          </div>
                                          <!-- /.box-body -->
                                            <input type="hidden" name="paymentId" value="'.$data->id.'" />
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">'.__('messages.close').'</button>
                                    <button type="submit" class="btn btn-primary">'.__('messages.save').'</button>
                                  </div>
                                </div>
                                </form>
                              </div>
                            </div>';
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true)
        ;
    }
    
    private function generetateInvoiceNumber()
    {
        return time();
    }

    public function filterByPlane(){
        //Opens a view with all planes to futher filter pending payments
        // $planes = Plane::all();
        return view('pages.backend.payments.select-list')
            // ->with('planes',$planes)
            ;
    }

    public function pendingPaymentsByPlane(Request $request){
        //Opens a view with all pending payments from a plane id
        $planeTail = $request->planeTail;
        $payments = Payment::where('status','PENDING')
            ->whereHas('plane', function($q) use($planeTail){
                $q->where('tail_number',$planeTail);
            })
            ->with('client')
            ->get()
            ;
        if($payments->count() == 0){
            return redirect()
                ->route('payments/filter/plane')
                ->withErrors(Lang::get('validation.payments.plane_not_found_or_pending'))
                ;
        }
        return view('pages.backend.payments.filter-pending')
            ->with('payments',$payments)
            ;
    }

    public function payCreated(Request $request,$paymentId){
        //Edit pending payment to change it's satus to APPROVED
        $reference = $request->reference;
        $clientId = $request->clientId;
        $description = $request->description;
        $payment = Payment::find($paymentId);
        
        // $client = Client::find($clientId);
        // if($client->balance < $payment->total_amount){
        //     return redirect()->back()->withErrors(Lang::get('validation.payments.not_enough_money'));
        // }
        
        $payment->reference = $reference;
        $payment->description = $description;
        $payment->status = 'APPROVED';
        $payment->save();
            
        // $client->balance = $client->balance - $payment->total_amount;
        // $client->save();

        return redirect()->route('payments');
    }

    public function createPayByAirplane(Request $request, $paymentId){
        
        $payment = Payment::where('id',$paymentId)
            ->with('client')
            ->with('fees')
            ->first()
            ;
        $taxes = 0;
            foreach ($payment->fees as $fee) {
                $taxes = $taxes + $fee->conversion_fee;
            }
        $payment->taxes = $taxes;
        $payment->subTotal = $payment->total_amount - $taxes;
        return view('pages.backend.payments.pay-existing')
            ->with('payment',$payment)
            ;
    }
}


