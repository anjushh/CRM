@extends('layouts.dashboard')
@section('content')

@if(isset($create_records))
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Status</th>
                  <th scope="col">Edit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($create_records as $create_record)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $create_record->name }}</td>
                        <td>{{ \App\Status::where('id',$create_record->status)->pluck('status_type')->first() }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('status_update.edit',$create_record->id) }}"><i class="fa fa-edit"></i></a>
                        </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection