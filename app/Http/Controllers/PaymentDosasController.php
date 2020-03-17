<?php
namespace app\Http\Controllers;

use App\Payment;
use App\PaymentDocument;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\PaymentDosa;


class PaymentDosasController extends Controller
{
    public function index($paymentId)
    {
        $payment = Payment::find($paymentId);
        $dosas = PaymentDosa::where('payment_id', $paymentId)->get();
        return view('pages.backend.payment-dosas.dosas')
            ->with('dosas', $dosas)
            ->with('payment', $payment)
        ;
    }
    
}
