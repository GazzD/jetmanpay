<?php
namespace app\Http\Controllers;

use App\Client;
use App\Payment;
use App\Plane;
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
    public function pending()
    {
        $clients = Client::all();
        return view('pages.backend.pending-payments')
            ->with('clients',$clients)
        ;
    }
    
    public function payments()
    {
        $clients = Client::all();
        return view('pages.backend.payments')
            ->with('clients',$clients)
        ;
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
        // Datatable functionality (pagination, filter, order)
        return $this->getPayments(true);
    }
    
    public function storeJson(Request $request)
    {
//         // Json file name
//         $fileName = Str::random(10).'.json';
        
//         // Validate json file
//         if ($request->hasFile('jsonFile')) {
//             // Store json file
//             $request->jsonFile->storeAs('public/payments', $fileName);
            
//             // Pase json file
//             $path = storage_path('app/public/payments/'.$fileName);
//             $payments = json_decode(file_get_contents($path), true);
//             foreach ($payments as $jsonPayment) {
//                 // Load payment data
//                 $client = Client::where('code', $jsonPayment['DOSA']['taxpayer_code'])->first();
//                 $plane = Plane::where('tail_number', $jsonPayment['DOSA']['tailnumber'])->first();
//                 $invoiceNumber = $this->generetateInvoiceNumber();
                
//                 // Create payment
//                 $payment = new Payment();
//                 $payment->dosa_number = $jsonPayment['DOSA']['dosa_number'];
//                 $payment->invoice_number = $invoiceNumber;
//                 $payment->dosa_date = $jsonPayment['DOSA']['dosa_date'];
//                 $payment->total_amount = $jsonPayment['DOSA']['total'];
//                 $payment->plane_id = $plane->id;
//                 $payment->client_id = $client->id;
//                 $payment->reference = strtoupper($client->name.' FAC '.$invoiceNumber.' DOSA '. $payment->dosa_number);
//                 $payment->description = strtoupper($client->name.' FAC '.$invoiceNumber.' DOSA '. $payment->dosa_number);
//                 $payment->user_id = auth()->user()->id;
                
//                 // Store payment
//                 $payment->save();
                
//                 // Create payment fees
//                 $paymentFees = array();
//                 foreach ($jsonPayment['DOSA']['fees'] as $jsonFee) {
//                     $paymentFee = [];
//                     $paymentFee['old_code'] = $jsonFee['old_code'];
//                     $paymentFee['concept'] = $jsonFee['concept'];
//                     $paymentFee['amount'] = $jsonFee['amount'];
//                     $paymentFee['conversion_fee'] = $jsonFee['conversion_fee'];
//                     $paymentFee['payment_id'] = $payment->id;
//                     $paymentFee['created_at'] = date('Y-m-d H:i:s');
//                     $paymentFee['updated_at'] = date('Y-m-d H:i:s');
//                     $paymentFees[] = $paymentFee;
//                 }
//                 // Store payment fees
//                 PaymentFee::insert($paymentFees);
//             }
//         }
        
        return redirect()->route('load-json')->with('status', __('messages.upload-json.success-message'));
    }
    
    public function manual(Request $request){
        // Opens a form to create AND pay directly an invoice
        $planes = Plane::all();
        return view('pages.backend.payments.manual-payment')
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
        $payment->number = 'ISP-'.$this->generateRandomString();
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
        $payment = Payment::with('items')->with('client')->with('plane')->find($id);
        
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
            $subtotal += $item->amount-$item->fee;
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
            ->with('items')
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
            $button .= '<li><i class="text-muted fas fa-exclamation" data-toggle="modal" data-target="#create-claim-'.$data->id.'" data-placement="top" title="'.__('messages.pending-payments.add-claim').'"></i></></li>';
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
            $button .= '<!-- Create claim Modal -->
                        <div class="modal fade" id="create-claim-'.$data->id.'" tabindex="-1" role="dialog">
                          <div class="modal-dialog" role="document">
                            <!-- form start -->
                            <form role="form" action="'.route('claims/store').'" class="form-horizontal form-label-left" method="post">
                            <div class="modal-content">
                              <div class="modal-body">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">'.__('messages.claims.add_claim').'</h3>
                                    </div>
                                    <!-- /.box-header -->
                                      '.csrf_field().'
                                      <div class="box-body row">
                                      <div class="col-md-12">  
                                        <div class="form-group">
                                          <select class="form-control" name="type">
                                            <option value="AMOUNT">'.__('messages.claims.incorrect_amount').'</option>
                                            <option value="FILE">'.__('messages.claims.incorrect_file').'</option>
                                            <option value="OTHER">'.__('messages.claims.other').'</option>
                                          </select>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea  rows="4" cols="62" class="from-control" name="description" placeholder="'.__('messages.claims.description').'"></textarea>
                                            </div>
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
    
    public function filterByPlane()
    {
        // Opens a view with all planes to futher filter pending payments
        return view('pages.backend.payments.select-list');
    }
    
    public function pendingPaymentsByPlane(Request $request)
    {
        // Opens a view with all pending payments from a plane id
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

    public function payCreated(Request $request,$paymentId)
    {
        // Edit pending payment to change it's satus to APPROVED
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

    public function createPayByAirplane(Request $request, $paymentId)
    {
        $payment = Payment::where('id',$paymentId)
            ->with('client')
            ->with('items')
            ->first()
        ;
        $taxes = 0;
        foreach ($payment->items as $item) {
            $taxes = $taxes + $item->fee;
        }
        $payment->taxes = $taxes;
        $payment->subTotal = $payment->total_amount - $taxes;
        return view('pages.backend.payments.pay-existing')
            ->with('payment',$payment)
        ;
    }

    public function generateReport(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $clientId = $request->clientId;
        $currency = $request->currency;
        $status = $request->status;
        $excelToggle = $request->excelToggle; //If on = Excel, if null = PDF
        $client = Client::find($clientId);
        $user = Auth::user();
        $payments = Payment::where('dosa_date','>',$from)
            ->where('dosa_date','<',$to)
            ->with('client')
            ->with('plane')
            ->where('user_id',$user->id)
            ->get()
        ;
        if($clientId > 0){
            $payments = $payments->where('client_id',$clientId);
        }
        if($currency != 'ALL'){
            $payments = $payments->where('currency',$currency);
        }
        if($status != 'ALL'){
            if($status == 'FINISHED'){
                $payments = $payments->where('status','!=','PENDING');
            }else{
                $payments = $payments->where('status',$status);
            }
        }
        // $payments = Payment::with('plane')->with('client')->get();
        $totalBs = 0;
        $totalUSD = 0;
        foreach ($payments as $payment){
            if($payment->currency == 'USD'){
                $totalUSD = $totalUSD + $payment->total_amount;
            }else{
                $totalBs = $totalBs + $payment->total_amount;
            }
            //Calculate amount before commission 
            $totalFee = 0;
            foreach($payment->items as $item){
                $totalFee = $totalFee + $item->amount;
            }
            $payment->amount_before_commission = $payment->total_amount - $totalFee;
        }
        /*
        Generate report
        If excelToggle == null generate PDF, if not, generate excel file
        */
        if(!$excelToggle){
            //Generate pdf
            $data = [
                'payments' => $payments,
                'from' => $from,
                'to' => $to,
                'client' => $client,
                'now' => date("Y-m-d h:i:sa"),
                'totalUSD' => $totalUSD,
                'totalBs' => $totalBs,
            ];
            
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            
            return $pdf
                ->loadView('pdf.payments-report', $data)
                ->download('payments-report.pdf')
            ;
        }else{
            return Excel::download(new PaymentsExport($from, $to,$clientId, $status, $user, $currency), 'payment-reports-'.$from.'_'.$to.'.xlsx');
        }
    }
    
    private function generetateInvoiceNumber()
    {
        return time();
    }
}


