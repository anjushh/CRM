@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-3">
                {!! Form::select('choose_status',$status->pluck('status_type','id'), Input::old('choose_status'), array('placeholder' => 'Choose Status','class' => 'form-control choose_status')) !!}    
            </div>
            <div class="col-3">
                {!! Form::select('choose_time',['1'=>'Daily','2'=>'Monthly','3'=>'Quarterly','4'=>'Six Months','5'=>'Yearly'], Input::old('choose_time'), array('placeholder' => 'Choose Report Span','class' => 'form-control choose_time')) !!}
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
    jQuery(function() {
        var route = "{{ route('client.data', 'item') }}";
        jQuery('body').on('change', '.choose_status', function(e) {
            var id = jQuery(this).val();
            var getData = {};
            jQuery.ajax({
                method: "GET",
                dataType: "json",
                url: route.replace('item', id ),            
                success: function(getData) {
                    var datas = getData.clients_datas;
                }
            });
        });
    });
</script>
@endsection