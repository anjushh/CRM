@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>User</strong> Master</div>
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
                {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['user.update', $edit_records->id]]) !!}
            @else
                {!! Form::open(array('route' => 'user.store','method'=>'POST')) !!}
            @endif
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('name', Input::old('name'), array('placeholder' => 'Enter Name','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::email('email', Input::old('email'), array('placeholder' => 'Enter Email Address','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::password('password',array('placeholder' => 'Enter Password','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::password('password_confirm',array('placeholder' => 'Confirm Password','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('mobile', Input::old('mobile'), array('placeholder' => 'Enter Mobile Number','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('designation', Input::old('designation'), array('placeholder' => 'Enter Designation','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
            	<div class="form-group">
                    {!! Form::select('user_type',$user_datas->pluck('user_type','id'),null, array('placeholder' => 'Select User Type','class' => 'form-control d-inline-block float-left')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="d-inline-block mt-3">Active</label>
                    {!! Form::checkbox('status', Input::old('status'),null, array('class' => 'form-control d-inline-block w-5 pt-2')) !!}
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	            {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-25 float-left btn-primary btn-xl ml-2']) }}
	            {{ Form::close() }}
	        </div>
		</div>
	</div>
</div>

@if(isset($create_records))
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Contact Number</th>
                  <th scope="col">User Role</th>
                  <th scope="col">Status</th>
                  <th scope="col">Edit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($create_records as $create_record)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $create_record->name }}</td>
                        <td>{{ $create_record->mobile }}</td>
                        <td>
                            {{ \App\Models\UserType::where('id',$create_record->user_type)->pluck('user_type')->first() }}
                        </td>
                        <td>
                        @if($create_record->status == 1)
                        	Active
                        @else 
                        	Inactive
                        @endif
                        <td><a class="btn btn-success btn-sm" href="{{ route('user.edit',$create_record->id) }}"><i class="fa fa-edit"></i></a></td>
                  </tr>
                  @endforeach
                  
              </tbody>
            </table>
        </div>
    </div>
    {{ $create_records->links() }}
</div>
@endif
@endsection