<?php
namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

class PaymentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
     // Varible form and to 
     public function __construct(String $from = null , 
        String $to = null, 
        $clientId = null, 
        $status = False,
        $user = 'ALL', 
        $currency= 'ALL'
        )
     {
         $this->from = $from;
         $this->to   = $to;
         $this->clientId = $clientId;
         $this->status = $status;
         $this->user = $user;
         $this->currency = $currency;
     }
     
     // Function select data from database 
     public function collection()
     {
        $payments = Payment::select('currency','total_amount','description','dosa_date','number','client_id','status','plane_id','user_id')
            ->where('dosa_date','>',$this->from)
            ->where('dosa_date','<',$this->to)
            ->with('client')
            ->with('plane')
            ->get()
            ;
        if($this->clientId > 0){
            $payments = $payments->where('client_id',$this->clientId);
        }
        if($this->user != 'ALL'){
            $payments = $payments->where('user_id',$this->user->id)
            ;
        }
        if($this->currency != 'ALL'){
            $payments = $payments->where('currency',$this->currency);
        }
        if($this->status != 'ALL'){
            if($this->status == 'FINISHED'){
                $payments = $payments->where('status','!=','PENDING');
            }else{
                $payments = $payments->where('status',$this->status);
            }
        }
        foreach($payments as $payment){
            $payment->plane_id = null;
            $payment->user_id = null;
            if($payment->plane){
                $payment->client_id = $payment->plane->tail_number.'/'.$payment->client->name;
            }else{
                $payment->client_id = null;
            }
        }
        $totalBs = 0;
        $totalUSD = 0;
        foreach ($payments as $payment){
            if($payment->currency == 'USD'){
                $totalUSD = $totalUSD + $payment->total_amount;
            }else{
                $totalBs = $totalBs + $payment->total_amount;
            }
        }
        // Blank row
        $emptyRow = new Payment();
        $emptyRow->currency = null;
        $emptyRow->total_amount = '';
        
        // Date row
        $dateRow = new Payment();
        $dateRow->currency = Lang::get('messages.reports.report_generated');
        $dateRow->total_amount = date("Y/m/d");
        
        // Total Amount (usd) row
        $usdRow = new Payment();
        $usdRow->currency = Lang::get('messages.reports.total_usd');
        $usdRow->total_amount = $totalUSD;
        
        // Total Amount (BsS) row
        $bssRow = new Payment();
        $bssRow->currency = Lang::get('messages.reports.total_bs');
        $bssRow->total_amount = $totalBs;
        $payments->push($emptyRow);
        $payments->push($dateRow);
        $payments->push($usdRow);
        $payments->push($bssRow);
        return $payments;  
     }
     /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

     //function header in excel
     public function headings(): array
     {
         return [
            Lang::get('messages.payments.currency'),
            Lang::get('messages.reports.total_amount'),
            Lang::get('messages.reports.description'),
            Lang::get('messages.reports.date'),
            Lang::get('messages.reports.receipt'),
            Lang::get('messages.reports.tail_client'),
            Lang::get('messages.reports.status'),
        ];
    }
}

