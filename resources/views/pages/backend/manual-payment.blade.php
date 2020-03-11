@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.manual-payments.manual-payments')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.manual-payments.manual-payments')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <form method="post" action="#" enctype=multipart/form-data role="form" class="form-horizontal">
        <input type="hidden" id="csrf" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.manual-payments.plane')</label>
            <div class="col-md-10">
                <select class="form-control" name="planeId" required="required" id="planes">
                    <option value="null">@lang('messages.manual-payments.choose-one')</option>
                    @foreach($planes as $plane)
                        <option value="{{$plane->id}}">{{$plane->tail_number}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.manual-payments.client')</label>
            <div class="col-md-10">
                <select class="form-control" name="clientId" required="required" id="clients">
                    <option value="null">@lang('messages.manual-payments.choose-one')</option>

                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.manual-payments.currency')</label>
            <div class="col-md-10">
                <select class="form-control" name="currency" required="required" id="currency">
                    <option value="USD">USD ($)</option>
                    <option value="VEF">VEF (BsS)</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.manual-payments.reference')</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="Reference" id="reference" class="form-control" name="reference">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.manual-payments.description')</label>
            <div class="col-md-10">
                <textarea class="form-control" style="max-width: 100%;" id="description" placeholder="Description" rows="8"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">TRADUCIR NEW ITEM</label>
            <div class="row">
                <div class="col-md-5">
                    <input type="text" required="" placeholder="Concept" id="feeConcept" class="form-control" name="feeConcept">
                </div>
                <div class="col-md-5">
                    <input type="number" required="" placeholder="Amount" id="feeAmount" class="form-control" name="feeConcept">
                </div>
                <div class="col-md-2">
                    <a class="btn btn-warning" id="addFee">+</a>
                </div>
            </div>
        </div>
        <div id="feeList">
        </div>
        <a href="#" id="submit-btn" class="btn btn-primary">Guardar</a>
	</form>
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
