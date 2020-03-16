<?php
namespace app\Http\Controllers;

use App\Payment;
use App\PaymentDocument;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


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
    
    public function store(Request $request)
    {
        // Validate json file
        if ($request->hasFile('documentFile')) {
//             dd($request->documentFile->getClientOriginalExtension());
            $fileName = Str::random(10).'.'.$request->documentFile->getClientOriginalExtension();
            // Store file
            $request->documentFile->storeAs('public/payments/documents', $fileName);
            
            $paymentDocument = new PaymentDocument();
            $paymentDocument->url = Storage::url('payments/documents/'.$fileName);
            $paymentDocument->name = $request->name;
            $paymentDocument->payment_id = $request->paymentId;
            $paymentDocument->save();
            
        }
        
        return redirect()->route('pending-payments')->with('status', __('messages.upload-json.success-message'));
    }
    
}
