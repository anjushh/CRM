@extends('layouts.dashboard')
@section('content')

@if(isset($records))
<div class="col-lg-12">
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
                    <tr>
                        <td> {{ $records }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection