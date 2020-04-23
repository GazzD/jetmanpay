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
        $user = auth()->user();
        $fileName = Str::random(10).'.'.$request->picture->getClientOriginalExtension();
        // Store file
        $request->picture->storeAs('public/payments/documents', $fileName);

        $recharge = new Recharge();
        $recharge->image =Storage::url('payments/documents/'.$fileName);
        $recharge->client_id = $user->client_id;  
        $recharge->user_id = $user->id;
        if($user->hasRole('CLIENT')){
            $recharge->status = 'PENDING';
        }elseif($user->hasRole('TREASURER1')){
            $recharge->status = 'REVISED1';
        }elseif($user->hasRole('TREASURER2')){
            $recharge->status = 'REVISED2';
        }else{
            return redirect()->back();
        }
        $recharge->save();          
        return redirect()->route('recharges');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $status = $request->status;
        $amount = $request->amount;
        $recharge = Recharge::find($id);
        if($user->hasRole('CLIENT')){
            if($status != 'PENDING' && $status !='REJECTED'){
                return redirect()->back();
            }
        }elseif($user->hasRole('TREASURER1')){
            if($status != 'REVISED1' && $status !='REJECTED'){
                return redirect()->back();
            }
        }elseif($user->hasRole('TREASURER2')){
            if($status != 'REVISED2'){
                return redirect()->back();
            }
        }
        $recharge->status = $status;
        $recharge->save();

        if($status == 'APPROVED'){
            $client = Client::find($recharge->client_id);
            $client->balance = $client->balance + $amount;
            $client->save();
        }
        return redirect()->route('recharges');
        
    }

    public function details($id){
        $recharge = Recharge::find($id);
        $user = auth()->user();
        $options = [];
        $isEditable = False;
        if($user->hasRole('REVIEWER')){
            $options = [
                'APPROVED',
                'REJECTED'
            ];
            if($recharge->status == 'PENDING'){
                $isEditable = True;
            }
        }elseif($user->hasRole('CLIENT')){
            $options = [
                'PENDING',
                'REJECTED'
            ];
            if($recharge->status == 'REVISED1'){
                $isEditable = True;
            }
        }elseif($user->hasRole('TREASURER1')){
            $options = [
                'REVISED1',
                'REJECTED'
            ];
            if($recharge->status == 'REVISED2'){
                $isEditable = True;
            }
        }
        $recharge->date = date_format($recharge->created_at,"d/m/Y/ H:i:s");
        return view('pages.backend.recharges.details')
            ->with('recharge',$recharge)
            ->with('options',$options)
            ->with('isEditable',$isEditable)
            ;
    }

    public function fetch()
    {
        $user = auth()->user();
        $recharges = [];
        if($user->hasRole('REVIEWER')){
            $recharges = Recharge::whereIn('status',['APPROVED','PENDING','REJECTED'])
                ->with('client')
                ->get()
                ;
        }elseif($user->hasRole('CLIENT')){
            $recharges = Recharge::where('client_id',$user->client_id)
                    ->whereIn('status',['APPROVED','PENDING','REJECTED','REVISED1'])
                    ->with('client')
                    ->get()
                    ;
        }elseif($user->hasRole('TREASURER1')){
            $recharges = Recharge::where('client_id',$user->client_id)
                ->whereIn('status',['REVISED1','REVISED2'])
                ->with('client')
                ->get()
                ;
        }elseif($user->hasRole('TREASURER2')){
            $recharges = Recharge::where('user_id',$user->id)
                ->with('client')
                ->get()
                ;
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
