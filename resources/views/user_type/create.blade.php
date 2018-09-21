@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>User Type</strong> Master</div>
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
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    @if(isset($records))
                    {!! Form::model($records, ['method' => 'PATCH','route' => ['user_type.update', $records->id]]) !!}
                    @else
                    {!! Form::open(array('route' => 'user_type.store','method'=>'POST','files'=>true)) !!}
                    @endif
                    {!! Form::text('user_type', Input::old('user_type'), array('placeholder' => 'Enter User Type','class' => 'form-control d-inline-block w-70 float-left')) !!}
                    {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-25 float-left btn-primary btn-xl ml-2']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @if(isset($user_records))
        <div class="card-body">
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user_records as $user_record)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user_record->user_type }}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('user_type.edit', $user_record->id) }}"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $user_records->links() }}
        </div>
        @endif
    </div>
</div>
@endsection