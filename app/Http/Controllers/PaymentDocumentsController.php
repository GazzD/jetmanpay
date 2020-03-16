<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\PaymentDocument;
use App\Payment;

class PaymentDocumentsController extends Controller
{
    public function index($paymentId)
    {
        $payment = Payment::find($paymentId);
        $documents = PaymentDocument::where('payment_id', $paymentId)->get();
        return view('pages.backend.payment-documents.documents')
            ->with('documents', $documents)
            ->with('payment', $payment)
        ;
    }
    
}
