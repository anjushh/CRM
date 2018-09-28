@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>Payment</strong></div>
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

            {!! Form::model($edit_records, ['method' => 'POST','route' => ['payment_status.store',$edit_records->id]]) !!}
            <!-- {{--Form Opened--}} -->
            <div class="form-group">
                {!! Form::text('client_id',$edit_records->client_id, array('hidden'=>'hidden')) !!}
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Outstanding Amount</label>
                    {!! Form::text('out_amount', Input::old('out_amount'), array('class' => 'form-control out_amount','readonly'=>'readonly')) !!}
                </div>  
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Amount Received</label>
                    {!! Form::text('amt_rcvd',Input::old('amt_rcvd'), array('placeholder' => 'Enter Received Amount','class' => 'form-control offered_price', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Date of Payment</label>
                    {!! Form::date('pay_date', Input::old('pay_date'), array('placeholder' => 'Enter Received Amount','class' => 'form-control recieved_amount', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Status</label>
                    {!! Form::select('status',['1' => 'Pending','2' => 'Complete'],null,array('placeholder' => 'Payment Status','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {{ Form::submit('Submit', ['name' => 'submit','class'=>'form-control d-inline-block w-50 float-left btn-primary btn-xl ml-2']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!-- {{-- Form Closed --}} -->
        {{ Form::close() }}
        <!-- {{-- Form Closed --}}  -->
    </div>
</div>
@endsection