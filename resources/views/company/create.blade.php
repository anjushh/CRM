@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-xl-6">
                <div class="master-subhead"><strong>Company</strong> Master</div>
            </div>
            <div class="col-xl-6 float-right">
                <div class="master-subhead"><a href="#view_all" class="btn btn-dark d-inline-block float-right text-light border-0 scroll">View all Company Profiles</a></div>
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
                {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['company.update', $edit_records->id],'files'=>true]) !!}
            @else
                {!! Form::open(array('route' => 'company.store','method'=>'POST','files'=>true)) !!}
            @endif
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('company_name', Input::old('company_name'), array('placeholder' => 'Enter Company Name','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('company_address', Input::old('company_address'), array('placeholder' => 'Enter Company Address','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::email('company_email', Input::old('company_email'), array('placeholder' => 'Enter Company Email','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('company_contact', Input::old('company_contact'), array('placeholder' => 'Enter Contact Number','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('company_gst', Input::old('company_gst'), array('placeholder' => 'Enter Company GST Number','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('company_pan', Input::old('company_pan'), array('placeholder' => 'Enter Company PAN Number','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4 pr-0">
            	@if(isset($edit_records))
                <div class="form-group w-100 d-inline-block">
                    {!! Form::file('company_logo',array('class' => 'form-control logo_update border-0', 'onchange'=>'uploadImage(this)')) !!}
                </div>
            	<div class="logo_preview w-100 d-inline-block">
                    <label id="image_error"></label>
                    <img id="image_preview" class="img-fluid" src="{{ asset('storage/'.$edit_records->company_logo) }}" />
                </div>
                @else
                <div class="form-group w-100 d-inline-block logo_block">
                    {!! Form::file('company_logo',array('class' => 'form-control logo_update border-0', 'onchange'=>'uploadImage(this)')) !!}
                </div>
                <div class="logo_preview w-100 d-inline-block">
                    <label id="image_error"></label>
                    <img id="image_preview" class="img-fluid" src="{{ asset('images/dummy-img.jpg') }}" />
                </div>
                @endif
            </div>
            <div class="offset-xl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="d-inline-block mt-3">Active</label>
                    {!! Form::checkbox('status', Input::old('status'),null, array('class' => 'form-control d-inline-block w-5 pt-2')) !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block">
	            {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-100 float-left btn-primary btn-xl ml-2 rounded-0']) }}
	            {{ Form::close() }}
	        </div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block">
                <input type="button" value="Clear All Values" onClick="resetAllValues();" class="form-control d-inline-block w-100 float-left btn-danger btn-xl ml-2 rounded-0">
            </div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block float-right">
                <a href="{{ url()->previous() }}" class="btn btn-primary w-100 float-right"><span class="fa fa-long-arrow-left"></span> Go Back</a>
            </div>
		</div>
	</div>
</div>

@if(isset($create_records))
<div class="col-lg-12" id="view_all">
    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email Address</th>
                  <th scope="col">Contact Number</th>
                  <th scope="col">Status</th>
                  <th scope="col">Edit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($create_records as $create_record)
                  <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{ $create_record->company_name }}</td>
                      <td>{{ $create_record->company_email }}</td>
                      <td>{{ $create_record->company_contact}}</td>
                      <td>
                        @if($create_record->status == 1)
                        	Active
                        @else 
                        	Inactive
                        @endif
                      <td><a class="btn btn-success btn-sm" href="{{ route('company.edit',$create_record->id) }}"><i class="fa fa-edit"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block float-right">
                <a href="{{ url()->previous() }}" class="btn btn-primary w-100 float-right"><span class="fa fa-long-arrow-left"></span> Go Back</a>
            </div>
        </div>
    </div>
    {{ $create_records->links() }}
</div>
@endif

<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
function uploadImage(input) {
    if (input.files && input.files[0]) {
        var extension = input.files[0].name.split('.').pop().toLowerCase(), //file extension from input file
        isSuccess = fileTypes.indexOf(extension) > -1;
        if (isSuccess) {
            $('.logo_preview').show();
            var reader = new FileReader();
            reader.onload = function (e) {
            $('#image_preview').attr('src', e.target.result);
            $('#imageUrl').val(e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            $('#image_preview').show();
            $('.sec_img').show();
            $("#image_error").html("");
            $("#submit_button").attr('disabled', false);
            $("#current_image").remove();
        } else {
            $("#image_error").html("Invalid Image Type");
            $("#image_error").css("color", "red");
            ('#image_preview').hide();
            $("#submit_button").attr('disabled', "disabled");
        }
    }

}
</script>
@endsection