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
        </div>
        @if(isset($create_records))
        <div class="card-body">
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="w-5">#</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Offered Price</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Edit Payment Details</th>
                            <th scope="col">Update Payment Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($create_records as $create_record)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                {{ $create_record->client_name($create_record->client_id) }}
                            </td>
                            <td>
                                {{ $create_record->offered_price }}
                            </td>
                            <td>
                                @if($create_record->pay_status($create_record->client_id))
                                    {{ $create_record->pay_status($create_record->client_id) }}
                                @else
                                Pending
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('payment.edit', $create_record->id) }}"><i class="fa fa-edit"></i></a>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{ route('payment_status.update', [$create_record->id,$create_record->pay_id($create_record->id)]) }}"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <!-- {{-- Form Closed --}} -->
        {{ Form::close() }}
        <!-- {{-- Form Closed --}}  -->
    </div>
</div>
@endsection