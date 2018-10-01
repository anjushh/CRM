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
            <!-- {{--Form Opened--}} -->
            {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['payment.store', $edit_records->id]]) !!}
            <!-- {{--Form Opened--}} -->
            
            <div class="form-group">
                {!! Form::text('client_id',$edit_records->client_id, array('hidden'=>'hidden')) !!}
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Offered Price</label>
                    {!! Form::text('offered_price',$edit_records->offered_price, array('placeholder' => 'Offered Price','class' => 'form-control offered_price', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Received Amount</label>
                    {!! Form::text('recieved_amount', Input::old('recieved_amount'), array('placeholder' => 'Enter Received Amount','class' => 'form-control recieved_amount', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="label_pay">Discount</label>
                    {!! Form::text('discount', Input::old('discount'), array('placeholder' => 'Enter Discount','class' => 'form-control discount', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 border-right-0 border-left-0 border-bottom-0 border mt-3 p-3">
                <label class="label_pay">Outstanding Amount</label>
                {!! Form::text('out_amount', Input::old('out_amount'), array('class' => 'form-control out_amount','readonly'=>'readonly')) !!}
            </div>
            <div class="clearfix"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    Installments: {!! Form::checkbox('check',Input::old('check'), array('class' => 'insta')) !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="insta_no">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        {!! Form::text('inst_1', Input::old('inst_1'), array('placeholder' => 'First Installment Amount','class' => 'form-control insta_1')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        {!! Form::date('inst_date_1', Input::old('inst_date_1'), array('placeholder' => 'First Installment Date','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group mt-0">
                        <label class="label_pay mb-0">Due Amount After First Installment</label>
                        {!! Form::text('out_amount_1', Input::old('out_amount_1'), array('class' => 'form-control out_amount_1','readonly'=>'readonly')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        {!! Form::text('inst_2', Input::old('inst_2'), array('placeholder' => 'Second Installment Amount','class' => 'form-control insta_2')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        {!! Form::date('inst_date_2', Input::old('inst_date_2'), array('placeholder' => 'Second Installment Date','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group mt-0">
                        <label class="label_pay mb-0">Due Amount After Second Installment</label>
                        {!! Form::text('out_amount_2', Input::old('out_amount_2'), array('class' => 'form-control out_amount_2','readonly'=>'readonly')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        {!! Form::text('inst_3', Input::old('inst_3'), array('placeholder' => 'Third Installment Amount','class' => 'form-control insta_3')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        {!! Form::date('inst_date_3', Input::old('inst_date_3'), array('placeholder' => 'Third Installment Date','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group mt-0">
                        <label class="label_pay mb-0">Due Amount After Third Installment</label>
                        {!! Form::text('out_amount_3', Input::old('out_amount_3'), array('class' => 'form-control out_amount_3','readonly'=>'readonly')) !!}
                    </div>
                </div>
            </div>
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
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
    outstanding_amount();
    function outstanding_amount(){
        var offered_price = jQuery('.offered_price').val();
        var discount = jQuery('.discount').val();
        var recieved_amount = jQuery('.recieved_amount').val();
        var remaining_amount = offered_price - recieved_amount;
        var outstanding_amount = remaining_amount - discount;
        jQuery('.out_amount').attr('value',outstanding_amount);
    }
    
    jQuery('.offered_price').keyup(function(event){
        outstanding_amount();
    });
    jQuery('.discount').keyup(function(event){
        outstanding_amount();
    });
    jQuery('.recieved_amount').keyup(function(event){
        outstanding_amount();
    });
    
</script>
<script type="text/javascript">
    jQuery(".insta").click(function(e) {
        if(jQuery(this).is(":checked")) {
            jQuery(".insta_no").show(400);
        } else {
            jQuery(".insta_no").hide(400);
        }
    });
</script>

<script type="text/javascript">
    insta_calc1();
    insta_calc2();
    insta_calc3();
    jQuery('.insta_1').keyup(function(event){
        insta_calc1();
        insta_calc2();
        insta_calc3();
    });
    jQuery('.insta_2').keyup(function(event){
        insta_calc1();
        insta_calc2();
        insta_calc3();
    });
    jQuery('.insta_3').keyup(function(event){
        insta_calc1();
        insta_calc2();
        insta_calc3();
    });
    function insta_calc1(){
        var out_amount = jQuery('.out_amount').val();
        var insta_1 = jQuery('.insta_1').val();
        var out_amount_1 = out_amount - insta_1;
        jQuery('.out_amount_1').attr('value',out_amount_1);
    }
    function insta_calc2(){
        var out_amount_1 = jQuery('.out_amount_1').val();
        var insta_2 = jQuery('.insta_2').val();
        var out_amount_2 = out_amount_1 - insta_2;
        jQuery('.out_amount_2').attr('value',out_amount_2);
    }
    function insta_calc3(){
        var out_amount_2 = jQuery('.out_amount_2').val();
        var insta_3 = jQuery('.insta_3').val();
        var out_amount_3 = out_amount_2 - insta_3;
        jQuery('.out_amount_3').attr('value',out_amount_3);
    }
</script>


@endsection
