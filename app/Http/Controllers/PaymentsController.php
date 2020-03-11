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

class PaymentsController extends Controller
{
    public function index()
    {
//         $payments = Payment::where('status', 'PENDING')
//         ->where('user_id', auth()->user()->id)
//         ->with('client')
//         ->with('plane')
//         ->with('user')
//         ->with('fees')
//         ->latest()
//         ->get();
        
//         dd($payments);

        return view('pages.backend.pending-payments')
//             ->with('payments', $payments)
            ;
    }

    public function json()
    {
        return view('pages.backend.json');
    }

    public function pendingPayments(Request $request)
    {
        // Datatable functionality (pagination, filter, order)
        return DataTables::of(
            Payment::where('status', 'PENDING')
                ->where('user_id', auth()->user()->id)
                ->with('client')
                ->with('plane')
                ->with('user')
                ->with('fees')
                ->latest()
                ->get()
            )
            ->addColumn('description', function($data){
                $description = strtoupper($data->client->name).'/';
                return $description;
            })
            ->addColumn('action', function($data){
                $button = '<button type="button" name="cancel-'.$data->id.'">Cancel</button>';
                return $button;
            })
            ->rawColumns(['description', 'action'])
            ->make(true)
        ;
        
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
                // Create payment
                $payment = new Payment();
                $payment->dosa_number = $jsonPayment['DOSA']['dosa_number'];
                $payment->dosa_date = $jsonPayment['DOSA']['dosa_date'];
                $payment->total_amount = $jsonPayment['DOSA']['total'];
                $payment->tail_number = $jsonPayment['DOSA']['tailnumber'];
                $payment->client_id = Client::where('code', $jsonPayment['DOSA']['taxpayer_code'])->first()->id;
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
        $payment->plane_id = $planeId;
        $payment->client_id = $clientId;
        $payment->user_id = $userId;
        $payment->currency = $currency;
        $payment->reference = $reference;
        $payment->description = $description;
        $payment->status = 'APPROVED';
        $payment->total_amount = $totalAmount;
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

}


