<html>
<head>
  <style>
    @page { font-family: "Arial Narrow", Arial, sans-serif; margin: 100px 25px;}
    header { position: fixed; top: -100px; left: -25px; right: -25px; background-color: lightblue; height: 50px; }
    .main { font-size: 15px; }
    .sub { font-size: 13px; }
    .payment-info { line-height: 0.5; margin-top: 20px;}
    .payment-table { text-align: center; }
    .payment-total { margin-top: 10px; }
    footer { position: fixed; bottom: -100px; left: -25px; right: -25px; line-height: 1; background-color: gray; height: 120px; text-align: center; color: #FFF; }
/*     footer>p footer>a { font-size: 58px; font-weight: 100; } */
/*     p:last-child { page-break-after: never; } */
  </style>
</head>
<body>
  <header>
    <img alt="" src="https://i.imgur.com/xzYsgNt.png" />
  </header>
  <footer>
    <p>BCDA Aeronautical Solutions LLC</p>
    <a href="https://www.google.com/maps?q=14200+NW+42nd+Avenue&entry=gmail&source=g">14200 NW 42nd Ave suite 188</a>
    <p>Opa locka , FL 33054, United States</p>
  </footer>
  <main>
    <br />
    <div class="payment-info">
        <p class="main">TAIL NUMBER</p>
        <p class="sub">{{ $payment->plane->tail_number}}</p>
        <p class="main">BILL NUMBER</p>
        <p class="sub">IPS-{{ $payment->number }}</p>
        <p class="main">BILL REFERENCE</p>
        <p class="sub">{{ $payment->reference }}</p>
        <p class="main">INVOICE NUMBER/DOSA</p>
        <p class="sub">{{ $payment->invoice_number }}/{{ $payment->dosa_number }}</p>
        <p class="main">ADDRESS</p>
        <p class="sub">Iere House, Golden Grove Road, Piarco, Trinidad And Tobago, Arima-Tunapuna-Piarco, (00000)</p>
    </div>
    <div class="payment-table">
        <p style="font-size: 20px; text-align: center;">PAYMENT CONFIRMATION</p>
        <table style="width:100%">
            <thead>
              <tr style="font-size: 16px; margin-bottom: 100px;">
                <th>MERCHANT</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>BILL REFERENCE</th>
                <th>INSTRUMENT</th>
                <th>ENDING WITH</th>
              </tr>
            </thead>
            <tbody style="text-align: center;">
              <tr style="font-size: 13px;">
                <td>iam_merchant</td>
                <td>{{ $payment->dosa_date }}</td>
                <td>19:03</td>
                <td>{{ $payment->reference }}</td>
                <td>VIRTUAL CARD</td> 
                <td>0951</td>
              </tr>
            </tbody>
        </table>
    </div>
    <div class="payment-table" style="color:{{$color}};">
        <h1>{{ $payment->status }}</h1>
    </div>
    <div class="payment-fees">
        <table style="width:100%">
            <thead>
              <tr style="font-size: 16px; margin-bottom: 100px;">
                <th>PRODUCT/CONCEPT</th>
                <th>AMOUNT</th>
              </tr>
            </thead>
            <tbody style="text-align: center;">
              @foreach($payment->items as $item)
              <tr style="font-size: 13px;">
                <td>{{ $item->concept }}</td>
                <td>{{ $currency }}{{ $item->amount }}</td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    <div class="payment-total">
        <table style="float: right;">
            <thead>
              <tr style="font-size: 13px; margin-bottom: 100px;">
                <th>CURRENCY</th>
                <th>{{ $payment->currency }}</th>
              </tr>
            </thead>
            
            <tbody>
              <tr style="font-size: 13px;">
                <td>SUB TOTAL</td>
                <td>{{ $currency }}{{ $subtotal }}</td>
              </tr>
              <tr style="font-size: 13px;">
                <td>TAX</td>
                <td>{{ $currency }}{{ $tax }}</td>
              </tr>
              <tr style="font-size: 13px;">
                <td>APP FEE</td>
                <td>{{ $currency }}{{ $appfee }}</td>
              </tr>
              <tr style="font-size: 13px;">
                <td>TOTAL</td>
                <td>{{ $currency }}{{ $payment->total_amount }}</td>
              </tr>
            </tbody>
        </table>
    </div>
  </main>
</body>
</html>