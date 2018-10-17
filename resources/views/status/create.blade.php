@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>Status</strong> Master</div>
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
                    @if(isset($edit_records))
                    {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['status.update', $edit_records->id]]) !!}
                    @else
                    {!! Form::open(array('route' => 'status.store','method'=>'POST','files'=>true)) !!}
                    @endif
                    {!! Form::text('status_type', Input::old('status_type'), array('placeholder' => 'Enter Status Type','class' => 'form-control d-inline-block w-70 float-left')) !!}
                    {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-25 float-left btn-primary btn-xl ml-2']) }}
                    {{ Form::close() }}
                </div>
                <input type="button" value="Clear All" onClick="resetAllValues();" class="form-control d-inline-block w-30 float-left btn-danger btn-xl rounded-0 w-20 float-left">
            </div>
        </div>
        @if(isset($create_records))
        <div class="card-body">
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="w-7">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($create_records as $create_record)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $create_record->status_type }}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('status.edit', $create_record->id) }}"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $create_records->links() }}
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block float-right">
                <a href="{{ url()->previous() }}" class="btn btn-primary w-100 float-right"><span class="fa fa-long-arrow-left"></span> Go Back</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection