<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Recharge;
use App\Client;

class RechargesController extends Controller
{
    public function index(Request $request)     
    {
        return view('pages.backend.recharges.index');
    }

    public function create()
    {
        return view('pages.backend.recharges.create');
    }

    public function store(Request $request)
    {
        // Validate file
        $validator = Validator::make($request->all(), [
            'picture' => 'required|mimes:jpeg,png',
        ]);
      
        $fileName = Str::random(10).'.'.$request->picture->getClientOriginalExtension();
        // Store file
        $request->picture->storeAs('public/payments/documents', $fileName);

        $recharge = new Recharge();
        $recharge->image =Storage::url('payments/documents/'.$fileName);
        $recharge->client_id = auth()->user()->client_id;  
        $recharge->save();          
        return redirect()->route('recharges');
    }

    public function update(Request $request, $id)
    {
        $status = $request->status;
        $amount = $request->amount;
        $recharge = Recharge::find($id);
        if(auth()->user()->hasRole('MANAGER')){
            $recharge->status = $status;
            $recharge->save();
        }
        if($status == 'APPROVED'){
            $client = Client::find($recharge->client_id);
            $client->balance = $client->balance + $amount;
            $client->save();
        }
        return redirect()->route('recharges');
        
    }

    public function details($id){
        $recharge = Recharge::find($id);
        return view('pages.backend.recharges.details')
            ->with('recharge',$recharge)
            ;
    }

    public function fetch()
    {
        if(auth()->user()->hasRole('CLIENT')){
            $recharges = Recharge::where('client_id',auth()->user()->client_id)
                    ->with('client')
                    ->get()
                    ;
        }else{
            $recharges = Recharge::with('client')->get();
        }
        foreach ($recharges as $recharge) {
            $recharge->date = date_format($recharge->created_at,"d/m/Y/ H:i:s");
        }
        // Return datatable
        return DataTables::of($recharges)
            ->addColumn('action', function($data){
            $button = '<ul class="fc-color-picker" id="color-chooser">';
            $button .= '<li><a class="text-muted" href="'.route('recharges/details', $data->id).'"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="'.__('messages.recharges.details').'"></i></a></li>';
            $button .= '</ul>';
            
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true)
        ;
    }
}
