@extends('layouts.dashboard')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Dashboard</div> -->
                <div class="card-body">
                </div>
                <div class="content mt-3 charts_wrapper">
                @if ($message = Session::get('success'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                        <span class="badge badge-pill badge-success">Success</span>
                            {{ $message }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            <div class="col-lg-3 col-md-6 col-xl-3">
                <div class="card text-white bg-flat-color-1">
                    <div class="card-body pb-0 home_charts">
                        <h3 class="mb-0">
                            <span class="count">{{ $total_projects }}</span>
                        </h3>
                        <p class="text-light">Total Projects</p>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <i class="fa fa-bar-chart float-right"></i>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xl-3">
                <div class="card text-white bg-flat-color-12">
                    <div class="card-body pb-0 home_charts">
                        <h3 class="mb-0">
                            <span class="count">{{ $pending_projects }}</span>
                        </h3>
                        <p class="text-light">Pending Projects</p>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <i class="fa fa-bar-chart float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xl-3">
                <div class="card text-white bg-flat-color-3">
                    <div class="card-body pb-0 home_charts">
                        <h3 class="mb-0">
                            <span class="count">{{ $process_projects }}</span>
                        </h3>
                        <p class="text-light">In Process Projects</p>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <i class="fa fa-bar-chart float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xl-3">
                <div class="card text-white bg-flat-color-5">
                    <div class="card-body pb-0 home_charts">
                        <h3 class="mb-0">
                            <span class="count">{{ $closed_projects }}</span>
                        </h3>
                        <p class="text-light">Closed Projects</p>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <i class="fa fa-bar-chart float-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-xl-3">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0 home_charts">
                        <h3 class="mb-0">
                            <span class="count">{{ $refused_projects }}</span>
                        </h3>
                        <p class="text-light">Refused Projects</p>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <i class="fa fa-bar-chart float-right"></i>
                            <canvas id="widgetChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-xl-3">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0 home_charts">
                        <h3 class="mb-0">
                            <span class="count">{{ $refused_projects }}</span>
                        </h3>
                        <p class="text-light">Refused Projects</p>
                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <img class="d-block img-fluid" src="{{ asset('images/trophy.svg') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-lg-12 col-md-12 my-3">
                <div class="h5">Select Year</div>
                {!! Form::select('choose_year',$years->pluck('year'),date('Y'),array('class' => 'form-control choose_year float-left w-25','placeholder' => 'Choose Year')) !!} 
                <button class="btn btn-brown text-light w-50 text-center float-left">Show</button>
            </div>
            <!--/.col-->
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        {!! $chartjs->render() !!}
                    </div>
                </div>
            </div>
            <!--/.col-->

                <!-- <div class="card-body">
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
                    
                </div> -->
            </div>
        </div>
    </div>
</div>

@endsection
