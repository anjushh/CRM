@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card">
    	<div class="card-body card-block">
			<table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="w-5">#</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Reminder Date</th>
                        <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($create_records as $create_record)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $create_record->name }}</td>
                        <td>{{ $create_record->rem_date }}</td>
                        <td>{{ $create_record->remarks }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    	</div>
    	{{ $create_records->links() }}
    </div>
</div>
@endsection