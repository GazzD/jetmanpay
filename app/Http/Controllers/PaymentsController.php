<?php
namespace app\Http\Controllers;

use App\Client;
use App\Payment;
use App\PaymentFee;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{
    public function index()
    {
        return view('pages.backend.documents');
    }
    
    public function json()
    {
        return view('pages.backend.json');
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
    
}


