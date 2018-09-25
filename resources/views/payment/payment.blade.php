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
            @if(isset($edit_records))
            {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['services.update', $edit_records->id]]) !!}
            @else
            {!! Form::open(array('route' => 'services.store','method'=>'POST','files'=>true)) !!}
            @endif
            <!-- {{--Form Opened--}} -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('offered_price',Input::old('offered_price'), array('placeholder' => 'Offered Price','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <a class="btn btn-primary">Add Discount</a>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('discount', Input::old('discount'), array('placeholder' => 'Add Discount','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('service_name', Input::old('service_name'), array('placeholder' => 'Enter Service Name','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('service_name', Input::old('service_name'), array('placeholder' => 'Enter Service Name','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('service_name', Input::old('service_name'), array('placeholder' => 'Enter Service Name','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('service_name', Input::old('service_name'), array('placeholder' => 'Enter Service Name','class' => 'form-control', 'required'=>'required')) !!}
                </div>
            </div>
              
        </div>
        @if(isset($create_records))
        <div class="card-body">
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($create_records as $create_record)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('payment.edit', $create_record->id) }}"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        {{-- Form Closed --}}
            {{ Form::close() }}
            {{-- Form Closed --}} 
    </div>
</div>
@endsection