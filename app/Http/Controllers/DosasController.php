<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
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
        
        $dosas = Dosa::where('client_id', auth()->user()->client_id)->get();
        return view('pages.backend.dosas.client-dosas')
            ->with('dosas', $dosas)
        ;
    }
    
    public function dosaDetail($dosaId)
    {
        // Validate user
        $dosa = Dosa::find($dosaId);
        
        return view('pages.backend.dosas.dosa-detail')
            ->with('dosa', $dosa)
        ;
    }
    
}

