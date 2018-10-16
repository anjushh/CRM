@extends('layouts.dashboard')
@section('content')
@if(isset($edit_records))
    {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['reminder.update', $edit_records->id]]) !!}
@else
    {!! Form::open(array('route' => 'reminder.store','method'=>'POST')) !!}
@endif
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-9">
                <div class="master-subhead"><strong>Create Reminder</strong></div>
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
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body card-block">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Reminder Date</label>
                    {!! Form::date('rem_date', Input::old('rem_date'), array('placeholder' => 'Reminder Date','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Select Client</label>
                    {!! Form::select('client_id',$clients->pluck('name','id'),Input::old('client_id'), array('placeholder' => 'Select Client','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Remarks</label>
                    {!! Form::textarea('remarks', Input::old('remarks'), array('placeholder' => 'Enter Remarks if Any','class' => 'form-control remarks')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    <label class="d-inline-block mt-3">Active</label>
                    {!! Form::checkbox('status', Input::old('status'),null, array('class' => 'form-control d-inline-block w-5 pt-2')) !!}  
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
                {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-100 float-left btn-primary btn-xl rounded-0 mb-5']) }}
                {{ Form::close() }}
            </div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block">
                <input type="button" value="Clear All Values" onclick="resetAllValues();" class="form-control d-inline-block w-100 float-left btn-danger btn-xl ml-2 rounded-0">
            </div>
        </div>
    </div>
</div>
@if(isset($reminders))
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-striped">
              <thead>
                <tr>
                  <th scope="col" class="w-5">#</th>
                  <th scope="col">Client Name</th>
                  <th scope="col">Reminder Date</th>
                  <th scope="col">Status</th>
                  <th scope="col" class="w-15">Edit</th>
                  <th scope="col" class="w-15">Delete Reminder</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reminders as $reminder)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $reminder->client_name}}</td>
                        <td>{{ $reminder->rem_date }}</td>
                        <td>
                            @if($reminder->status == 1)
                                Active
                            @else 
                                Inactive
                            @endif
                        <td><a class="btn btn-success btn-sm" href="{{ route('reminder.edit',$reminder->id) }}"><i class="fa fa-edit"></i></a></td>
                        <td><a class="btn btn-danger btn-sm rounded-circle" href="{{ route('reminder.delete', $reminder->id) }}"><i class="fa fa-minus"></i></a></td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endif
{{ Form::close() }}

@endsection