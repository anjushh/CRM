@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-3">
                {!! Form::select('choose_lead',$leads->pluck('name','id'), Input::old('choose_lead'), array('placeholder' => 'Choose Client','class' => 'form-control choose_lead rounded-0')) !!}    
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
        jQuery('select').css("pointer-events","auto");
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

        var route = "{{ route('lead.data','lead_id') }}";
        var id = jQuery(this).val();
        var getData = {};
        jQuery.ajax({
            method: "GET",
            dataType: "json",
            url: route.replace('lead_id',lead_id),          
            success: function(getData) {
                console.log(getData);
                // jQuery("#table_id > tbody").html("");
                // for (var i = getData.clients_datas.length - 1; i >= 0; i--) {
                //     console.log(getData.clients_datas[i].id);
                //     var _row = '<tr role="row"><td class="sorting_1">'+getData.clients_datas[i].client_name+'</td><td>'+getData.clients_datas[i].created_at+'</td><td>'+getData.clients_datas[i].project_status+'</td><td class="pay_data">'+ get_payment(getData.clients_datas[i].id) +'</td><td>'+getData.clients_datas[i].lead_name+'</td></tr>';
                //     jQuery('tbody').append(_row);
                // }
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