@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>Client</strong> Master</div>
            </div>
        </div>
        <div class="card-body card-block">
            <div class="col-12">
                @if($errors->any())
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                @if($errors = Session::get('success'))
                 <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Success</span>
                    Data Saved Successfully
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            {{--Form Opened--}}
            @if(isset($edit_records))
            {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['client.update', $edit_records->id]]) !!}
            @else
            {!! Form::open(array('route' => 'client.store','method'=>'POST','files'=>true)) !!}
            @endif
            {{--Form Opened--}}
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('name', Input::old('name'), array('placeholder' => 'Enter Client Name','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('business_name', Input::old('business_name'), array('placeholder' => 'Enter Business Name','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('address', Input::old('address'), array('placeholder' => 'Enter Address','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('email', Input::old('email'), array('placeholder' => 'Enter Email Address','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('phone_no', Input::old('phone_no'), array('placeholder' => 'Enter Phone Number','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('alt_contact', Input::old('alt_contact'), array('placeholder' => 'Enter Alternate Contact Number','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::select('product',$services->pluck('service_name','id'),null, array('placeholder' => 'Choose Service','class' => 'form-control service_change', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('product_price', Input::old('product_price'), array('placeholder' => 'Service Price','class' => 'form-control service_price', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::select('conv_type',$convs->pluck('conv_type','id'),null, array('placeholder' => 'Conversation Medium','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::select('lead_head',$execus->pluck('name','id'),null, array('placeholder' => 'Choose Lead Manager','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::date('anni_date',Input::old('anni_date'), array('placeholder' => 'Anniversay Date','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::date('birth_date',Input::old('birth_date'), array('placeholder' => 'Birth Date','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::text('remarks',Input::old('remarks'), array('placeholder' => 'Enter Remarks','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::text('follow_ups',Input::old('follow_ups'), array('placeholder' => 'Enter Folloups','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::select('status',$statuses->pluck('status_type','id'),null, array('placeholder' => 'Choose Status','class' => 'form-control status_change', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 final_date">
                <div class="form-group">
                    {!! Form::date('finali_date',Input::old('finali_date'), array('placeholder' => 'Finalization Date','class' => 'form-control final_date','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 start_date">
                <div class="form-group">
                    {!! Form::date('start_date',Input::old('start_date'), array('placeholder' => 'Project Start Date','class' => 'form-control start_date','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 end_date">
                <div class="form-group">
                    {!! Form::date('end_date',Input::old('end_date'), array('placeholder' => 'Project Ending Date','class' => 'form-control end_date','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 time_period">
                <div class="form-group">
                    {!! Form::number('time_period',Input::old('time_period'), array('placeholder' => 'Enter Time Period','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-25 float-left btn-primary btn-xl ml-2']) }}
                {{ Form::close() }}
            </div>
            {{-- Form Closed --}}
            {{ Form::close() }}
            {{-- Form Closed --}}   
        </div>
        @if(isset($create_records))

        <div class="card-body">
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Service Price</th>
                            @php $j = user_type(); @endphp
                            @if($j == 1) 
                                <th scope="col">Edit</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($create_records as $create_record)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $create_record->name }}</td>
                            <td>{{ $create_record->product_price }}</td>
                            @php $j = user_type(); @endphp
                            @if($j == 1) 
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('client.edit', $create_record->id) }}"><i class="fa fa-edit"></i></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $create_records->links() }}
        </div>
        @endif
    </div>
</div>
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>

<script type="text/javascript">
jQuery(function() {
    var route = "{{ route('client.price', 'item') }}";
    jQuery('body').on('change', '.service_change', function(e) {
        var id = jQuery(this).val();
        console.log(id);
        var getData = {};
        jQuery.ajax({
            method: "GET",
            dataType: "json",
            url: route.replace('item', id ),            
            success: function(getData) {
                jQuery('.service_price').attr('value',getData.service_price);
            }
        });
    });
});

jQuery('body').on('change', '.status_change', function(e) { 
    var status_id = jQuery(this).val();
    if(status_id == '3') {
        jQuery('.final_date').show();
        jQuery('.start_date').show();
        jQuery('.end_date').show();
        jQuery('.time_period').show();
    }
    else {
        jQuery('.final_date').hide();
        jQuery('.start_date').hide();
        jQuery('.end_date').hide();
        jQuery('.time_period').hide();
    }
});
</script>
@endsection