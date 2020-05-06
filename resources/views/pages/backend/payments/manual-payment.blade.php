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
    <form method="post" action="{{route('manual-payments')}}" role="form" class="form-horizontal">
    @csrf
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.plane')</label>
                        <select class="form-control" name="planeId" required="required" id="planes">
                            <option value="null">@lang('messages.manual-payments.choose-one')</option>
                            @foreach($planes as $plane)
                                <option value="{{$plane->id}}">{{$plane->tail_number}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.client')</label>
                        <select class="form-control" name="clientId" required="required" id="clients">
                            <option value="null">@lang('messages.manual-payments.choose-one')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.currency')</label>
                        <select class="form-control" name="currency" required="required" id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="VEF">VEF (BsS)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.reference')</label>
                        <input type="text" required="" placeholder="@lang('messages.manual-payments.reference')" id="reference" class="form-control" name="reference">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.description')</label>
                        <textarea name="description" class="form-control" style="max-width: 100%;" id="description" placeholder="Description" rows="8"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.payments.invoice_items')</label>
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" placeholder="@lang('messages.payments.concept')" id="feeConcept" class="form-control" name="feeConcept">
                    </div>
                    <div class="col-md-5">
                        <input type="number" placeholder="@lang('messages.payments.amount')" id="feeAmount" class="form-control" name="feeConcept">
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-warning" id="addFee">+</a>
                    </div>
                </div>
            </div>
            <div id="feeList">
            </div>
            
            <div id="totalAmount">
            </div>
            <input type="hidden" name="itemList" id="itemList" />
        </div>
        <div class="card-footer">
            <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.payments.confirm')</button>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')
<script type="text/javascript">

    var feeList = [];

    function reloadFeeList(array) {
        // Assign item list 
        $('#itemList').val(JSON.stringify(array));
        
        //Reload list
        $('#feeList').empty();
        let row = `
        <div class="row">
            <div class="col-md-4">
                <h3>@lang('messages.payments.concept')</h3>
            </div>
            <div class="col-md-4">
                <h3>@lang('messages.payments.amount')</h3>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        `;
        $('#feeList').append(row);
        let totalAmount = 0;
        for(let i = 0; i < array.length; i++){
            // Calculate total amount
        	totalAmount += parseFloat(array[i].amount);
        	
        	// Rewrite rows
            let row = `
            <div class="row" style="margin: 10px 0;">
                <div class="col-md-4">
                    ${array[i].concept}
                </div>
                <div class="col-md-4">
                    ${array[i].amount}
                </div>
                <div class="col-md-4">
                <a class="btn btn-danger deleteFee" id="${i}"><i class="fas fa-trash" style="color:white;"></i></a>
                </div>
            </div>
            `;
            
            let totalRow = '<div style="text-align: end;"><h2>Total '+ $('#currency').val() + ' ' + totalAmount + '</h2></div>';
            
            // Rewrite rows
            $('#feeList').append(row);
            $('#totalAmount').html(totalRow);
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

//     $('#submit-btn').click(function(){
//         let data = {
//             'planeId' : $('#planes').val(),
//             'clientId' : $('#clients').val(),
//             'currency' : $('#currency').val(),
//             'reference' : $('#reference').val(),
//             'description' : $('#description').val(),
//             'feeList' : feeList
//         }
//         let config = {
//             'headers': {
//                 'X-CSRFToken' : $('#csrf').val(),
//                 }
//         };
//         console.log('=============DATA===============');
//         console.log(data);
//         console.log('================================');
//         axios.post('/payments/manual',data,config).then(response => {
//             console.log(response.data.policy_id);
//             window.location.replace('/payments');


//         }).catch(e => {
//             console.log(e);
//             alert('Hubo un problema al guardar la póliza, porfavor revise sus datos e intente de nuevo');
//         });
//     });

</script>
@endsection
