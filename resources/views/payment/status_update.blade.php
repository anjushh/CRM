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
            {!! Form::model($edit_records, ['method' => 'POST','route' => ['payment_status.store',$edit_records->id,$edit_records->payment_id($edit_records->id)]]) !!}
            <!-- {{--Form Opened--}} -->
            
            @if($edit_records->out_amount == 0)
                <div class="text-center w-100 mt-4">
                    There is no outstanding amount.<br/>
                    We have received whole payment of this client.
                    <div class="clearfix"></div>
                    <a href="{{ route('all_payments') }}" class="btn btn-primary d-inline-block mx-auto mt-5"><span class="ti-arrow-left"></span> Go Back</a>
                </div>
            @else
                <div>
                    {!! Form::text('client_id',$edit_records->client_id, array('hidden'=>'hidden')) !!}
                    {!! Form::text('remain_amt',Input::old('remain_amt'), array('hidden'=>'hidden','class'=>'remain_amt')) !!}
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="label_pay">Outstanding Amount</label>
                        {!! Form::text('out_amount',$edit_records->out_amount('$edit_records->id'), array('class' => 'form-control out_amount','readonly'=>'readonly')) !!}
                    </div>  
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="label_pay">Amount Received</label>
                        {!! Form::text('amt_rcvd','',array('placeholder' => 'Enter Received Amount','class' => 'form-control amt_rcvd','required'=>'required')) !!}
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="label_pay">Date of Payment</label>
                        <div class="clearfix"></div> 
                        {!! Form::date('pay_date','', array('placeholder' => 'Enter Received Amount','class' => 'form-control recieved_amount d-inline-block w-100', 'required'=>'required')) !!}
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        {{ Form::submit('Submit', ['name' => 'submit','class'=>'form-control d-inline-block w-50 float-left btn-primary btn-xl ml-2']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        </div>
        <!-- {{-- Form Closed --}} -->
        {{ Form::close() }}
        <!-- {{-- Form Closed --}}  -->
    </div>
</div>
<div class="clearfix"></div>
<!-- Button to Open the Modal -->


<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
    remaining_amount();
    function remaining_amount(){
        var out_amount = jQuery('.out_amount').val();
        var amt_rcvd = jQuery('.amt_rcvd').val();
        var remain_amt = out_amount - amt_rcvd;
        jQuery('.remain_amt').attr('value',remain_amt);
    }
    jQuery('.amt_rcvd').keyup(function(event){
        remaining_amount();
    });
</script>
@endsection