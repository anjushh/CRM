@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="col-6">
                <div class="master-subhead"><strong>Service</strong> Master</div>
            </div>
            <div class="col-6 float-right">
                <div class="master-subhead"><a href="#view_all" class="btn btn-dark d-inline-block float-right text-light border-0 scroll">View all Services</a></div>
            </div>
        </div>
        <div class="card-body card-block">
            <div class="col-12">
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
            {{--Form Opened--}}
            @if(isset($edit_records))
            {!! Form::model($edit_records, ['method' => 'PATCH','route' => ['services.update', $edit_records->id]]) !!}
            @else
            {!! Form::open(array('route' => 'services.store','method'=>'POST','files'=>true)) !!}
            @endif
            {{--Form Opened--}}
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::text('service_name', Input::old('service_name'), array('placeholder' => 'Enter Service Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    {!! Form::select('service_type',$service_types->pluck('service_type','id'),null, array('placeholder' => 'Choose Service Type','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    <select name="parent_id" class="form-control">
                        <option selected="selected" value>Select Main Service</option>
                        @foreach($parent_ids as $parent_id)
                        @if(empty($parent_id->parent_id))
                            <option class="level-1" value="{{ $parent_id->id }}">{{ $parent_id->service_name }}</option>
                                @php
                                    $child_ids = $parent_id->parent_id($parent_id->id);
                                @endphp
                                @foreach($child_ids as $child_id)
                                <option class="level-2" value="{{ $parent_id->id }}"><div class="level-2"> {{ $child_id->service_name }}</div>
                                </option>
                                @endforeach
                            @else
                                {{ $parent_id->service_name }}
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    {!! Form::text('service_price',Input::old('service_price'), array('placeholder' => 'Enter Service Price','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    <label class="d-inline-block mt-3">Active</label>
                    {!! Form::checkbox('status', Input::old('status'),null, array('class' => 'form-control d-inline-block w-5 pt-2')) !!}  
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                {{ Form::submit('Save', ['name' => 'submit','class'=>'form-control d-inline-block w-100 float-left btn-primary btn-xl rounded-0']) }}
                {{ Form::close() }}
            </div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block">
                <input type="button" value="Clear All Values" onClick="resetAllValues();" class="form-control d-inline-block w-100 float-left btn-danger btn-xl ml-2 rounded-0">
            </div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-inline-block float-right">
                <a href="{{ url()->previous() }}" class="btn btn-primary w-100 float-right"><span class="fa fa-long-arrow-left"></span> Go Back</a>
            </div>
            {{-- Form Closed --}}
            {{ Form::close() }}
            {{-- Form Closed --}}   
        </div>
        @if(isset($create_records))
        <div class="card-body" id="view_all">
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
                            <td>{{ $create_record->service_name }}</td>
                            <td>{{ $create_record->service_price }}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('services.edit', $create_record->id) }}"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $create_records->links() }}
        </div>
        @endif
    </div>
</div>
@endsection