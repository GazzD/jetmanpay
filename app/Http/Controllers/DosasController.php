<?php
namespace app\Http\Controllers;

use App\Client;
use App\Dosa;
use App\Payment;
use App\Plane;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

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
    
    public function filterByPlane()
    {
        $planes = Plane::where('client_id', auth()->user()->client_id)->get();
        // Opens a view with all planes to futher filter pending payments
        return view('pages.backend.dosas.select-list')->with('planes', $planes);
    }
    
    public function pendingByPlane(Request $request)
    {
        // Opens a view with all planes to futher filter pending payments
        $plane = Plane::where('tail_number', $request->tailNumber)->first();
        
        if (!$plane) {
            return redirect()
                ->route('payments/filter/plane')
                ->withErrors(Lang::get('validation.dosa.plane_not_found'))
            ;
        }
        
        return redirect()->route('dosas/plane/tail-number', $plane->id);
    }
    
    public function clientDosas($planeId)
    {
        // Find dosas
        $dosas = Dosa::where('client_id', auth()->user()->client_id)
            ->where('plane_id', $planeId)
            ->where('status', 'PENDING')
            ->get()
        ;
        
        // Render view
        return view('pages.backend.dosas.client-dosas')
            ->with('dosas', $dosas)
        ;
    }
    
    public function detail($dosaId)
    {
        // Validate user
        $dosa = Dosa::find($dosaId);
        
        // Render view
        return view('pages.backend.dosas.dosa-detail')
            ->with('dosa', $dosa)
        ;
    }
    
    public function pay(Request $request)
    {
        $dosasToPay = $request->get('dosasToPay');
        $dosas = Dosa::where('client_id', auth()->user()->client_id)->where('status', 'PENDING')->whereIn('id', $dosasToPay)->get();
        $client = Client::find(auth()->user()->client_id);
        dd($client->balance);
        $totalAmount = 0;
        foreach ($dosas as $dosa) {
            $totalAmount+=$dosa->total_dosa_amount;
        }
        
        if ($totalAmount > $client->balance)
            return redirect()->back()->withErrors(['msg', __('messages.dosa.insufficient-balance')]);
        
        dd($dosas);
    }
    
}

