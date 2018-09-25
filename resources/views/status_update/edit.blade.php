@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>Status </strong>Update</div>
            </div>
        </div>
        <div class="card-body card-block">
            <div class="col-12">
                @if(session()->has('message'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Failed</span>
                            {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Failed</span>
                            {{ $error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endforeach
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
            @if(isset($edit_records))
                {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['status_update.update', $edit_records->id,$client_id],'files'=>true]) !!}
            @else
                {!! Form::open(array('route' => 'status_update.store','method'=>'POST','files'=>true)) !!}
            @endif
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('name',\App\Client::where('id',$edit_records->client_id)->pluck('name')->first(), array('placeholder' => 'Enter Name','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::select('status_type',$statuses->pluck('status_type','id'),Input::old('status_type'), array('placeholder' => 'Choose Status','class' => 'form-control status_change', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 next_followup">
                <div class="form-group">
                    {!! Form::date('next_followup', Input::old('next_followup'), array('placeholder' => 'Select Next Followup Date','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 finali_date1">
                <div class="form-group">
                    {!! Form::date('finali_date',Input::old('finali_date'), array('placeholder' => 'Finalization Date','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 start_date1">
                <div class="form-group">
                    {!! Form::date('start_date',Input::old('start_date'), array('placeholder' => 'Project Start Date','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 end_date1">
                <div class="form-group">
                    {!! Form::date('end_date',Input::old('end_date'), array('placeholder' => 'Project Ending Date','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 time_period1">
                <div class="form-group">
                    {!! Form::number('time_period',Input::old('time_period'), array('placeholder' => 'Enter Time Period','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            @if(isset($edit_records->finali_date))
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::date('finali_date',Input::old('finali_date'), array('placeholder' => 'Finalization Date','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            @endif
            @if(isset($edit_records->start_date))
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::date('start_date',Input::old('start_date'), array('placeholder' => 'Project Start Date','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            @endif
            @if(isset($edit_records->end_date))
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::date('end_date',Input::old('end_date'), array('placeholder' => 'Project Ending Date','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            @endif
            @if(isset($edit_records->time_period))
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::number('time_period',Input::old('time_period'), array('placeholder' => 'Enter Time Period','class' => 'form-control','novalidate' => 'novalidate')) !!}
                </div>
            </div>
            @endif
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::textarea('remarks', Input::old('remarks'), array('placeholder' => 'Add Remarks','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="form-group w-20">
                    <div class="file_upload">
                        Attach File: <span class="fa fa-paperclip"></span><a class="btn btn-primary mx-2 rounded">Browse...</a> 
                        {!! Form::file('doc[]', Input::old('doc[]'), array('placeholder' => 'Choose File','class' => 'form-control d-inline-block float-left')) !!}
                    </div>
                </div>
            </div>
            <div id="new_file">
            </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="form-group">
                    <a class="btn btn-primary add_file">+ Add More</a>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-25 float-left btn-primary btn-xl ml-2']) }}
                {{ Form::close() }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
jQuery('body').on('change', '.status_change', function(e) { 
    var status_id = jQuery(this).val();
    if(status_id == '3') {
        jQuery('.finali_date1').show();
        jQuery('.start_date1').show();
        jQuery('.end_date1').show();
        jQuery('.time_period1').show();
        jQuery('.next_followup').hide();
    }
    else if(status_id == '4'){
        jQuery('.next_followup').hide();
    }
    else {
        jQuery('.finali_date1').hide();
        jQuery('.start_date1').hide();
        jQuery('.end_date1').hide();
        jQuery('.time_period1').hide();
        jQuery('.next_followup').show();
    }
});
</script>
<script type="text/javascript">
    var i = 1;
    jQuery('body').on('click', '.add_file', function(e) {
        jQuery("#new_file").append("<div class='col-xl-3 col-lg-3 col-md-6 col-sm-12 d-block'><div class='form-group w-20'><span class='fa fa-paperclip'></span><a class='btn btn-primary mx-2 rounded'>Browse...</a><input name='doc[]' type='file'></div></div>");
    });
    
</script>
<script type="text/javascript">
    function status_check(){
        var status_id = jQuery('.status_change').val();
        if(status_id == 3){
            jQuery('.next_followup').hide();
            jQuery('.status_change').attr('readonly','readonly');
        }
    }
    status_check();
</script>
@endsection