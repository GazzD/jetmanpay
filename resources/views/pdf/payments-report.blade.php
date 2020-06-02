<html>
<head>
  <style>
    @page { font-family: "Arial Narrow", Arial, sans-serif; margin: 10px 20px;}
    .center { text-align: center; justify-content: center;}
    footer { position: fixed; bottom: -100px; left: -25px; right: -25px; line-height: 1; background-color: gray; height: 120px; text-align: center; color: #FFF; }
/*     footer>p footer>a { font-size: 58px; font-weight: 100; } */
/*     p:last-child { page-break-after: never; } */
  </style>
</head>
<body>
    <header>
        
        <div class="center" style="font-size: 13px;">
            <div>Aero Payer</div>
            <div>@lang('messages.reports.payments_report')</div>
        </div>
                    
        <table style="width: 100%;">
        <tbody>
            <tr>
                <td>
                    <div style="line-height:11px; font-size:11px;">
                        <div>14200 NW 42nd Ave suite 188</div>
                        <div>BCDA Aeronautical Solutions LLC</div>
                        <div>Opa locka , FL 33054</div>
                        <div>United States</div>
                    </div>
                </td>
                <td style="text-align: right;">
                    <img src="https://i.imgur.com/HrxpWo4.png" style="height: 55px;">
                </td>
            </tr>
        </tbody>
    </table>
  </header>
  <main>
    <br />
    <div class="center" style="font-size: 9px; line-height:9px;">
        <div>@lang('messages.reports.from'): {{$from}} @lang('messages.reports.to'): {{$to}}</div>
        @if($client)
            <div>@lang('messages.reports.client'): {{$client->name}}</div>
        @endif
    </div>
    <table style="width:100%; border-collapse: collapse; border: 1px solid black;" >
        <thead>
          <tr style="font-size: 10px; background-color:#d0e0f6; margin-bottom: 100px; border: 1px solid black;">
            <th style="border: 1px solid black;">@lang('messages.reports.total_amount')</th>
            <th style="border: 1px solid black;">@lang('messages.reports.total_amount_before_comission')</th>
            <th style="border: 1px solid black;">@lang('messages.reports.description')</th>
            <th style="border: 1px solid black;">@lang('messages.reports.date')</th>
            <th style="border: 1px solid black;">@lang('messages.reports.receipt')</th>
            <th style="border: 1px solid black;">@lang('messages.reports.tail_client')</th>
            <th style="border: 1px solid black;">@lang('messages.reports.status')</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          @foreach($payments as $payment)
          <tr style="font-size: 9px;@if($loop->index % 2 != 0) background-color: lightgray; @endif border: 1px solid black;">
            <td style="border: 1px solid black;">@if($payment->currency =='USD')$ {{ $payment->amount_before_commission }} @else {{ $payment->amount_before_commission }} BsS @endif </td>
            <td style="border: 1px solid black;">@if($payment->currency =='USD')$ {{ $payment->total_amount }} @else {{ $payment->total_amount }} BsS @endif </td>
            <td style="border: 1px solid black;">{{ $payment->description }}</td>
            <td style="border: 1px solid black;">{{ $payment->dosa_date }}</td>
            <td style="border: 1px solid black;">{{ $payment->number }}</td>
            <td style="border: 1px solid black;">{{ $payment->plane->tail_number }} / {{ $payment->client->name }}</td>
            <td style="border: 1px solid black;">{{ $payment->status }}</td>
          </tr>
          @endforeach
        </tbody>
    </table>
    <div style="font-size: 9px; line-height:10px; margin-top: 5px;">
        <div>@lang('messages.reports.report_generated'): {{$now}}</div>
        <div>@lang('messages.reports.total_bs'): {{$totalBs}} BsS</div>
        <div>@lang('messages.reports.total_usd'): $ {{$totalUSD}}</div>
    </div>
  </main>
</body>
</html>