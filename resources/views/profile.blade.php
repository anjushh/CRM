@extends('layouts.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="card card_new">
        <div class="card-body">
            <section class="card">
                <div class="twt-feed blue-bg">
                    <div class="corner-ribon black-ribon">
                        <i class="fa fa-twitter"></i>
                    </div>
                    <div class="fa fa-twitter wtt-mark"></div>
                    <div class="media">
                        <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="images/admin.jpg">
                        <div class="media-body">
                            <h2 class="text-white display-6">{{ $user->name }}</h2>
                            <p class="text-light">{{ $user->designation }}</p>
                        </div>
                    </div>
                </div>
                <div class="weather-category twt-category">
                    <ul>
                        <li>
                            <h5>{{ $info->count() }}</h5>
                            Total Projects
                        </li>
                        <li>
                            <h5>{{ $info->where('status',1)->count() }}</h5>
                            Total Pending Projects
                        </li>
                        <li>
                            <h5>{{ $info->where('status',2)->count() }}</h5>
                            Total In Process Projects
                        </li>
                        <li>
                            <h5>{{ $info->where('status',3)->count() }}</h5>
                            Total Closed Projects
                        </li>
                        <li>
                            <h5>{{ $info->where('status',4)->count() }}</h5>
                            Total Refused Projects
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection