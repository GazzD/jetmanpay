<?php
namespace app\Http\Controllers;

use App\Client;
use App\Dosa;
use App\Payment;
use App\Plane;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;

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
        $planes = Plane::where('client_id', auth()->user()->client_id)
            ->whereHas('dosas', function($q){
                $q->where('status', 'PENDING');
            })
            ->get()
            ;
        // Opens a view with all planes to futher filter pending dosas
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
        $dosa = Dosa::find($dosaId);
        
        // Render view
        return view('pages.backend.dosas.dosa-detail')
            ->with('dosa', $dosa)
        ;
    }
    
    public function pay(Request $request)
    {   
        $tax = $this->getTaxes(); //15 %
        $taxMultiplier = ($tax/100)+1; //1.15
        $dosasToPay = $request->get('dosasToPay');
        if(!$dosasToPay){
            return redirect()->back()->withErrors([__('messages.dosa.select_dosas')]);
        }
        $dosas = Dosa::where('client_id', auth()->user()->client_id)->where('status', 'PENDING')->whereIn('id', $dosasToPay)->get();
        $client = Client::find(auth()->user()->client_id);
        $totalAmount = 0;
        foreach($dosas as $dosa){
            $conversionRate = $this->getConversionRate($dosa->currency,$client->currency);
            $dosa->convertedAmount = $dosa->total_dosa_amount * $conversionRate;
            $totalAmount = $totalAmount + ($dosa->convertedAmount);
        }

        $taxAmount = $totalAmount * ($taxMultiplier-1); 
        $totalAmount = $totalAmount * $taxMultiplier;
        $plane = Plane::find($dosas[0]->plane_id);
        return view('pages.backend.payments.dosa-payment')
            ->with('plane',$plane)
            ->with('dosas',$dosas)
            ->with('tax',$tax)
            ->with('client',$client)
            ->with('totalAmount',$totalAmount)
            ->with('taxAmount',$taxAmount)
            ;

        $totalAmount = 0;
        foreach ($dosas as $dosa) {
            $totalAmount+=$dosa->total_dosa_amount;
        }
        
        if ($totalAmount > $client->balance)
            return redirect()->back()->withErrors(['msg', __('messages.dosa.insufficient-balance')]);
        
        dd($dosas);
    }

    public function filterByApproved()
    {
        return view('pages.backend.dosas.approved');
    }

    public function fetchApproved()
    {
        $user = auth()->user();
        $dosas = Dosa::where('client_id',auth()->user()->client_id)
            ->where('status','APPROVED')
            ->get()
            ;
        
        // Return datatable
        return DataTables::of($dosas)
            ->addColumn('action', function($data){
            $button = '<ul class="fc-color-picker" id="color-chooser">';
            $button .= '<li><a class="text-muted" href="'.route('dosa-detail', $data->id).'"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="'.__('messages.dosas.details').'"></i></a></li>';
            $button .= '</ul>';
            
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true)
        ;
    }
    
}

