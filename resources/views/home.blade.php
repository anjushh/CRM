@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(active_company() != null)
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    @else
                    @if(user_type() == 1)
                        <div class="col-12">
                            <div class="card">
                                <div class="p-0 clearfix">
                                    <i class="fa fa-bell bg-danger p-4 font-2xl mr-3 float-left text-light"></i>
                                    <div class="h5 mb-0 pt-3">There is no Active Company. Create the Company First.</div>
                                </div>
                            </div>
                            <div class="w-100 text-center">
                                <a class="btn d-inline-block btn-primary" href="{{ route('company.create') }}"> Create Company </a>
                            </div>
                        </div>
                        @else 
                        <div class="col-12">
                            <div class="card">
                                <div class="p-0 clearfix">
                                    <i class="fa fa-bell bg-danger p-4 font-2xl mr-3 float-left text-light"></i>
                                    <div class="h6 mb-0 pt-1">There is no Active Company. Ask your administrator to provide Company.</div>
                                </div>
                            </div>
                            <div class="w-100 text-center">
                                <a class="btn d-inline-block btn-primary" href="{{ route('company.create') }}"> Create Company </a>
                            </div>
                        </div>
                        @endif    
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
