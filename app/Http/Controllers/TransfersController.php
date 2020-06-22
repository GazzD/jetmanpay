<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Transfer;
use App\System;

class TransfersController extends Controller
{
    public function index(){
        return view('pages.backend.transfers.index');
    }

    public function fetch(){
        $transfer = Transfer::all();

        // Return datatable
        return DataTables::of($transfer)
            ->addColumn('action', function($data){
            $button = '<ul class="fc-color-picker" id="color-chooser">';
            $button .= '<li><a class="text-muted" href="'.route('transfers/details', $data->id).'"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="'.__('messages.recharges.details').'"></i></a></li>';
            $button .= '</ul>';
            
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true)
        ;
    }

    public function create(){
        return view('pages.backend.transfers.create');
    }

    public function store(Request $request){

        // Validate
        $request->validate([
            'concept' => 'required|max:255',
            'amount' => 'required',
            'reference' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:4096',
        ]);

        // Defining file name
        $reference = Str::random(10).'.'.$request->reference->getClientOriginalExtension();
        
        // Store file
        $request->reference->storeAs('public/transfers/references', $reference);

        $transfer = new Transfer();
        $transfer->concept = $request->concept;
        $transfer->description = $request->description;
        $transfer->currency = $request->currency;
        $transfer->amount = $request->amount;
        $transfer->user_id = auth()->user()->id;
        $transfer->reference = Storage::url('transfers/references/'.$reference);
        $transfer->save();

        return redirect()->route('transfers');
    }

    public function details(Request $request, $id){
        $transfer = Transfer::findOrFail($id);
        return view('pages.backend.transfers.details')
            ->with('transfer',$transfer)
            ;
    }

    //Approve a transfer discounting the amount from the system's balance
    public function approve(Request $request){
        $transfer = Transfer::findOrFail($request->id);
        if($transfer->status == 'PENDING'){
            $systemInfo =  System::where('status','ACTIVE')->firstOrFail();

            //Compare the amount in the transfer with the corresponding balance in the correct currency and validates the amount is lesser than the current balance in the system
            switch ($transfer->currency){
                case 'USD':
                    if($transfer->amount > $systemInfo->balance_usd){
                        return redirect()->back()->withErrors([__('pages/transfers.insufficient_funds')]);
                    }else{
                        $systemInfo->balance_usd = $systemInfo->balance_usd - $transfer->amount;
                    }
                    break;
                case 'BS':
                    if($transfer->amount > $systemInfo->balance_bs){
                        return redirect()->back()->withErrors([__('pages/transfers.insufficient_funds')]);
                    }else{
                        $systemInfo->balance_bs = $systemInfo->balance_bs - $transfer->amount;
                    }
                    break;
                case 'EU':
                    if($transfer->amount > $systemInfo->balance_eu){
                        return redirect()->back()->withErrors([__('pages/transfers.insufficient_funds')]);
                    }else{
                        $systemInfo->balance_eu = $systemInfo->balance_eu - $transfer->amount;
                    }
                    break;
                
                default:
                    return redirect()->back();
                    break;
            }
            $systemInfo->save();
            $transfer->status = 'APPROVED';
            $transfer->save();
            return redirect()->route('transfers');
        }
    }
}
