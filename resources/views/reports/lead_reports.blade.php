@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-3">
                {!! Form::select('choose_lead',$leads->pluck('name','id'), Input::old('choose_lead'), array('placeholder' => 'Choose Client','class' => 'form-control choose_lead rounded-0')) !!}    
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
                        <th>Lead Manager</th>
                        <th>Designation</th>
                        <th>Total Projects</th>
                        <th>Total Closed Projects</th>
                        <th>Total Pending Projects</th>
                        <th>Total Refused Projects</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->desg($lead->user_type) }}</td>
                        <td>{{ $lead->pro_count($lead->id) }}</td>
                        <td>{{ $lead->close_count($lead->id) }}</td>
                        <td>{{ $lead->pen_count($lead->id) }}</td>
                        <td>{{ $lead->refuse_count($lead->id) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix"></div>

        </div>
    </div>
</div>
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
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
        var lead_id = jQuery('.choose_lead').val();
        var status = jQuery('.choose_status').val();
        if (jQuery('.choose_lead').val() != ''){
            var lead_id = jQuery('.choose_lead').val();
        }
        else {
            var lead_id = 0;
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

        var route = "{{ route('lead.data',['lead_id','from_date','to_date']) }}";
        var id = jQuery(this).val();
        var getData = {};
        jQuery.ajax({
            method: "GET",
            dataType: "json",
            url: route.replace('lead_id',lead_id).replace('from_date',from_date).replace('to_date',to_date),          
            success: function(getData) {
                jQuery("#table_id > tbody").html("");
                var tops = getData.leads;
                // For more than one Row
                var count = $.map(tops, function(n, i) { return i; }).length;
                if(count > 1){
                    $.each(getData.leads, function (index, value) {
                        var index = index;
                        var _row = '<tr role="row"><td class="sorting_1">'+getData.leads[index]['lead_name']+'</td><td>'+getData.leads[index]['desg']+'</td><td>'+getData.leads[index]['leads_count']+'</td><td>'+ getData.leads[index]['pending'] +'</td><td>'+getData.leads[index]['process']+'</td><td>'+getData.leads[index]['refuse']+'</td></tr>';
                        jQuery('tbody').append(_row);
                    });
                }
                else {
                    var _row = '<tr role="row"><td class="sorting_1">'+getData.leads['lead_name']+'</td><td>'+getData.leads['desg']+'</td><td>'+getData.leads['leads_count']+'</td><td>'+ getData.leads['pending'] +'</td><td>'+getData.leads['process']+'</td><td>'+getData.leads['refuse']+'</td></tr>';
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