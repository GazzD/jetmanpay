<html>
<head>
<style>
    @page {
    	font-family: "Arial Narrow", Arial, sans-serif;
    	margin: 150px 25px;
    }
    
    header {
    	position: fixed;
    	top: -160px;
    	left: -25px;
    	right: -25px;
    	background-color: lightblue;
    	height: 50px;
    }
    
    .main {
    	font-size: 15px;
    }
    
    .sub {
    	font-size: 13px;
    }
    
    .payment-info {
    	line-height: 0.5;
    }
    
    .payment-table {
    	text-align: center;
    }
    
    .payment-total {
    	margin-top: 10px;
    }
    
    footer {
    	position: fixed;
    	bottom: -150px;
    	left: -25px;
    	right: -25px;
    	line-height: 1;
    	background-color: gray;
    	height: 120px;
    	text-align: center;
    	color: #FFF;
    }
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
    <div class="payment-info">
        <p class="main">TAIL NUMBER</p>
        <p class="sub">{{ $payment->plane->tail_number}}</p>
        <p class="main">BILL NUMBER</p>
        <p class="sub">{{ $payment->number }}</p>
        <p class="main">BILL REFERENCE</p>
        <p class="sub">{{ $payment->reference }}</p>
        <p class="main">INVOICE NUMBER/DOSA</p>
        <p class="sub">{{ $payment->invoice_number }}/{{ $payment->dosa_number }}</p>
        <p class="main">ADDRESS</p>
        <p class="sub">{{ $address }}</p>
    </div>
    <div class="payment-table">
    	@if($payment->status == 'APPROVED')
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
        @else
        <p style="font-size: 20px; text-align: center;">PENDING PAYMENT</p>
        <table style="width:100%">
            <thead>
              <tr style="font-size: 16px; margin-bottom: 100px;">
                <th>DATE</th>
                <th>COMPANY NAME</th>
                <th>FISCAL INFORMATION REGISTER</th>
                <th>BILL DESCRIPTION</th>
              </tr>
            </thead>
            <tbody style="text-align: center;">
              <tr style="font-size: 13px;">
                <td>{{ $payment->dosa_date }}</td>
                <td>{{ $payment->client->name }}</td>
                <td>{{ $payment->client->rif }}</td>
                <td>{{ $payment->description }}</td>
              </tr>
            </tbody>
        </table>
        @endif
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
            <tbody>
              @foreach($payment->dosas as $dosa)
              	  <tr><td><b>DOSA {{$dosa->id_charge}}</b></td></tr>
                  @foreach($dosa->items as $item)
                  <tr style="font-size: 13px;">
                    <td>{{ $item->concept }}</td>
                    <td style="text-align: center;">{{ Currency::formatAmount($item->amount, $payment->currency) }}</td>
                  </tr>
                  @endforeach
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
                <td>{{ Currency::formatAmount($subtotal, $payment->currency) }}</td>
              </tr>
              <tr style="font-size: 13px;">
                <td>TAX</td>
                <td>{{ Currency::formatAmount($tax, $payment->currency) }}</td>
              </tr>
              <tr style="font-size: 13px;">
                <td>APP FEE</td>
                <td>{{ Currency::formatAmount($appfee, $payment->currency) }}</td>
              </tr>
              <tr style="font-size: 13px;">
                <td>TOTAL</td>
                <td>{{ Currency::formatAmount($payment->total_amount, $payment->currency) }}</td>
              </tr>
            </tbody>
        </table>
    </div>
  </main>
</body>
</html>