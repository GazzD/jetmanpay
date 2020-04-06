<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Mail\CreatedClaim;
use App\Claim; 

class ClaimsController extends Controller
{
    public function index(){
        return view('pages.backend.claims.index')
        ;
    }
    public function store(Request $request){
        $type = $request->type;
        $description = $request->description;
        $paymentId = $request->paymentId;
        $user = Auth::user();

        $claim = new Claim();
        $claim->type = $type;
        $claim->code = $this->generateRandomString();
        $claim->description = $description;
        $claim->user_id = $user->id;
        $claim->payment_id = $paymentId;
        $claim->save();

        //Send Email
//         $users = User::all();
        $emails  = explode(',', env('MAIL_CLAIM_TARGETS'));
        foreach ($emails as $email ) {
            Mail::to($email)->send(new CreatedClaim($claim->id));
            
        }
        return redirect()->back()->withMessage(Lang::get('messahes.claims.claim_made_success'));
    }

    public function details(Request $request, $id){
        $claim = Claim::where('id',$id)
            ->with('user')
            ->first()
            ;
        return view('pages.backend.claims.details')
            ->with('claim',$claim)
            ;
    }

    public function check($id){
        $claim = Claim::find($id);
        $claim->status = 'REVISED';
        $claim->save();

        return redirect()->route('claims');
    }

    public function fetch(){
        // Fetch claims
        $claims = Claim::where('user_id', auth()->user()->id)->with('user')->get();
        
        // Return datatable
        return DataTables::of($claims)
            ->addColumn('action', function($data){
            $button = '<ul class="fc-color-picker" id="color-chooser">';
            $button .= '<li><a class="text-muted" href="'.route('claims/details', $data->id).'"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="'.__('messages.claims.details').'"></i></a></li>';
            $button .= '</ul>';
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true)
        ;
    }

}
