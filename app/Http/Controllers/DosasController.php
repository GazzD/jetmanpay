<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Dosa;
use App\Payment;

class DosasController extends Controller
{
    
    public function paymentDosas($paymentId)
    {
        $payment = Payment::find($paymentId);
        $dosas = Dosa::where('payment_id', $paymentId)->get();
        return view('pages.backend.dosas.payment-dosas')
            ->with('dosas', $dosas)
            ->with('payment', $payment)
        ;
    }
    
    public function clientDosas()
    {
        // Validate user
        $notifications = Notification::where('user_id', auth()->user()->id)->latest()->limit(10)->get();
        
        return view('pages.backend.dosas.client-dosas')
            ->with('notifications', $notifications)
        ;
    }
}

