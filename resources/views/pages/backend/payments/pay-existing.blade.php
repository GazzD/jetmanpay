@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.payments.confirm_payment')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('payments/filter/plane') }}">@lang('messages.payments.payments_by_plane')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.payments.confirm_payment')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">@lang('messages.payments.confirm_payment')</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="{{route('payments/pay/store',$payment->id)}}" enctype=multipart/form-data role="form" class="form-horizontal">
        <div class="row">
            @csrf
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('messages.manual-payments.plane')</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" disabled name="planeId" required="required" id="planes">
                        <option selected value="{{$payment->plane->id}}">{{$payment->plane->tail_number}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('messages.manual-payments.client')</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" disabled name="clientId" required="required" id="clients">
                        <option selected value="{{$payment->client->id}}">{{$payment->client->name}}</option>
                    </select>
                </div>
            </div>
       
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('messages.payments.invoice_number')</label>
                    <input type="text" class="form-control" disabled name="invoice_number" value="{{$payment->invoice_number}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('messages.manual-payments.reference')</label>
                    <input type="text" required="" placeholder="Reference" id="reference" class="form-control" name="reference">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>@lang('messages.manual-payments.description')</label>
            <div class="col-md-12">
                <textarea class="form-control" style="max-width: 100%;" name="description" placeholder="@lang('messages.manual-payments.description')" rows="8"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label>@lang('messages.payments.fees')</label>
            @foreach ($payment->fees as $fee)
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-10">
                    <input type="text" value="{{$fee->concept}}" disabled placeholder="Concept" id="feeConcept" class="form-control" name="feeConcept">
                    </div>
                    <div class="col-md-2">
                        <input type="text" value=" @if($payment->currency == 'USD')${{$fee->amount - $fee->conversion_fee}} @else {{$fee->amount - $fee->conversion_fee}} BsS @endif" disabled placeholder="Amount" id="feeAmount" class="form-control" name="feeConcept">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row" style="text-align:right;">
            <div class="col-md-10">
                <label><h3>Sub-total</h3></label>
            </div>
            <div class="col-md-2">
                <h3> @if($payment->currency == 'USD')${{$payment->subTotal}} @else {{$payment->subTotal}} BsS @endif</h3>
            </div>
        </div>
        <div class="row" style="text-align:right;">
            <div class="col-md-10">
                <label><h3>@lang('messages.payments.taxes')</h3></label>
            </div>
            <div class="col-md-2">
                <h3> @if($payment->currency == 'USD')${{$payment->taxes}} @else {{$payment->taxes}} BsS @endif</h3>
            </div>
        </div>
        <div class="row" style="text-align:right;">
            <div class="col-md-10">
                <label><h3>Total</h3></label>
            </div>
            <div class="col-md-2">
                <h3> @if($payment->currency == 'USD')${{$payment->total_amount}} @else {{$payment->total_amount}} BsS @endif</h3>
            </div>
        </div>

        <div id="feeList">
        </div>
        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
        </form>
        </div>
    </div>
    </section>
<!-- /.content -->
@endsection
@section('extended-scripts')
<script type="text/javascript">

    var feeList = [];

    function reloadFeeList(array) {
        //Reload list
        $('#feeList').empty();
        let row = `
        <div class="row">
            <div class="col-md-4">
                <h3>Concept</h3>
            </div>
            <div class="col-md-4">
                <h3>Amount</h3>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        `;
        $('#feeList').append(row);
        for(let i = 0; i < array.length; i++){

            let row = `
            <div class="row">
                <div class="col-md-4">
                    ${array[i].concept}
                </div>
                <div class="col-md-4">
                    ${array[i].amount}
                </div>
                <div class="col-md-4">
                <a class="btn btn-warning deleteFee" id="${i}">Borrar</a>
                </div>
            </div>
            `;
            $('#feeList').append(row);
        }

        //This event has to be inside the reloadFeeList function because Javascript is fuking awful
        $('.deleteFee').on("click", function(e){
            //Eliminate element from list
            let index = e.target.id;
            feeList.splice(index,1);
            reloadFeeList(feeList);
        });
    }

    $('#planes').change(function(){
        //clean genres area
        $('#clients').html('');

        let planeId = $('#planes').val();

        axios.get(`/clients/fetch/plane/${planeId}`).then(response => {
        console.log(response.data);
        $('#clients').append(`<option value="${response.data.id}"> ${response.data.name}</option>`);
        }).catch(e => {
            console.log(e);
            alert('There was a problem loading the clients, please contact an administrator to solve the issue.');
        });
    });

    $('#addFee').click(function(){
        let feeConcept = $('#feeConcept').val();
        let feeAmount = $('#feeAmount').val();
        fee = {
            'concept' : feeConcept,
            'amount' : feeAmount,
        }
        feeList.push(fee);
        console.log('Fee List');
        console.log(feeList);
        //Clean input fields
        $('#feeConcept').val('');
        $('#feeAmount').val('');
        reloadFeeList(feeList);
    });

    $('#submit-btn').click(function(){
        let data = {
            'planeId' : $('#planes').val(),
            'clientId' : $('#clients').val(),
            'currency' : $('#currency').val(),
            'reference' : $('#reference').val(),
            'description' : $('#description').val(),
            'feeList' : feeList
        }
        let config = {
            'headers': {
                'X-CSRFToken' : $('#csrf').val(),
                }
        };
        console.log('=============DATA===============');
        console.log(data);
        console.log('================================');
        axios.post('/payments/manual',data,config).then(response => {
            console.log(response.data.policy_id);
            window.location.replace('/payments/pending');


        }).catch(e => {
            console.log(e);
            alert('Hubo un problema al guardar la póliza, porfavor revise sus datos e intente de nuevo');
        });
    });

</script>
@endsection
