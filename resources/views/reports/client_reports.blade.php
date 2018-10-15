@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-3">
                {!! Form::select('choose_client',$clients->pluck('name','id'), Input::old('choose_status'), array('placeholder' => 'Choose Client','class' => 'form-control choose_client rounded-0')) !!}    
            </div>
            <div class="col-3">
                {!! Form::select('choose_status',$status->pluck('status_type','id'), Input::old('choose_status'), array('placeholder' => 'Choose Status','class' => 'form-control choose_status rounded-0')) !!}    
            </div>
            <div class="col-3">
                {!! Form::text('from_date', Input::old('from_date'), array('placeholder' => 'From Date','class' => 'form-control datepick choose_from rounded-0','id' => 'datepicker11')) !!}    
            </div>
            <div class="col-3">
                {!! Form::text('to_date', Input::old('to_date'), array('placeholder' => 'To Date','class' => 'form-control choose_to datepick rounded-0','id' => 'datepicker2')) !!}    
            </div>
            <div class="clearfix"></div>
            <div class="col-3">
                <button class="btn mt-4 btn-brown text-light w-50 text-center show_report_btn">Show Report</button>
                <button class="btn mt-4 btn-brown text-light w-50 text-center" onclick="resetAllValues1()">Clear All</button>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Client Joining Date</th>
                        <th>Project Status</th>
                        <th>Payment Status</th>
                        <th>Project Manager</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client_datas as $client_data)
                    <tr>
                        <td>{{ $client_data->client_name }}</td>
                        <td>{{ date('d-m-Y', strtotime($client_data->created_at)) }}</td>
                        <td>{{ $client_data->project_status }}</td>
                        <td>
                            @if($client_data->payment_status($client_data->id) == 2)
                            Completed
                            @else
                            Pending
                            @endif
                        </td>
                        <td>{{ $client_data->lead_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script>
    jQuery('body').on('change', '.choose_client', function(e) {
        jQuery('.choose_status').val('');
        jQuery('.choose_status').attr('readonly','readonly');
        jQuery('.choose_status').css("pointer-events","none");
        jQuery('.choose_from').attr('readonly','readonly');
        jQuery('.choose_from').css("pointer-events","none");
        jQuery('.choose_to').attr('readonly','readonly');
        jQuery('.choose_to').css("pointer-events","none");
    });
    jQuery('body').on('change', '.choose_status', function(e) {
        jQuery('.choose_client').val('');
        jQuery('.choose_client').attr('readonly','readonly');
        jQuery('.choose_client').css("pointer-events","none");
    });
</script>
<script type="text/javascript">
    function resetAllValues1() {
        jQuery('select').val('');
        jQuery('select').removeAttr('readonly');
        jQuery('.datepick').prop("readonly","");
        jQuery('.datepick').css("pointer-events","auto");
        jQuery('select').css("pointer-events","auto");
        jQuery('.datepick').datepicker('setDate', null);
    }
</script>
<script type="text/javascript">
    jQuery('body').on('click','.show_report_btn', function() {
        var client_id = jQuery('.choose_client').val();
        var status = jQuery('.choose_status').val();
        if (jQuery('.choose_client').val() != ''){
            var client_id = jQuery('.choose_client').val();
        }
        else {
            var client_id = 0;
        }

        if (jQuery('.choose_status').val() != ''){
            var status = jQuery('.choose_status').val();
        }
        else {
            var status = 0;
        }

        if (jQuery('.choose_from').val() != ''){
            var from_date = jQuery('.choose_from').val();
        }
        else {
            var from_date = 0;
        }

        if (jQuery('.choose_to').val() != ''){
            var to_date = jQuery('.choose_to').val();
        }
        else {
            var to_date = 0;
        }
        var route = "{{ route('client.data',['client_id','status','from_date','to_date']) }}";
        var id = jQuery(this).val();
        var getData = {};
        jQuery.ajax({
            method: "GET",
            dataType: "json",
            url: route.replace('client_id',client_id).replace('status',status).replace('from_date',from_date).replace('to_date',to_date),          
            success: function(getData) {

                jQuery("#table_id > tbody").html("");
                for (var i = getData.clients.length - 1; i >= 0; i--) {

                    // alert(getData.clients[i].created_at);    

                    var _row = '<tr role="row"><td class="sorting_1">'+getData.clients[i].client_name+'</td><td>'+getData.clients[i].created_at+'</td><td>'+getData.clients[i].project_status+'</td><td class="pay_data">'+ get_payment(getData.clients[i].id) +'</td><td>'+getData.clients[i].lead_name+'</td></tr>';
                    jQuery('tbody').append(_row);
                }
            }
        });
    });
    function get_payment($id){
        var data;
        var route = "{{ route('get_payment','item') }}";
        var getData = '';
        jQuery.ajax({
            method: "GET",
            dataType: "json",
            async: false,
            url: route.replace('item',$id),            
            success: function(data) {
                getData = data;
            }
        });
        if(getData == 2){
            return 'Completed';
        }
        else {
            return 'Pending';
        }
    }
</script>
@endsection