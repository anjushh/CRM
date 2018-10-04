@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-9 text-center">
                <h4 class="mt-4">Please Add the Payment details first</h4>
                <a class="btn btn-primary rounded-0 mt-3" href="{{ route('all_payments') }}"><span class="fa fa-long-arrow-left"></span> Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection