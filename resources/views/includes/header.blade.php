
<!-- Header-->
<header id="header" class="header">
    <div class="header-menu">
        <div class="col-sm-7">
            <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search"></i></button>
                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>
                <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    @php
                        $notifications = notification();
                        $noti_count = count($notifications->where('read_status','1'));
                    @endphp
                    <span class="count noti_count bg-danger">{{ $noti_count }}</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="notification">
                        @php
                            $notifications = $notifications->sortByDesc('read_status')->slice(0, 5);
                        @endphp
                        @foreach($notifications as $notification)
                            <a class="dropdown-item msg_read media bg-flat-color-1" href="#">
                                <input value="{{ $notification->id }}" name="msg_read" hidden="hidden" class="noti_id">
                                <div class="w-15 d-inline-block float-left"><i class="ti-bell"></i></div>
                                <div class="w-85 d-inline-block float-left">
                                    <h6>{{ $notification->client_name }}</h6>
                                    <p>{{ $notification->remarks }}</p>
                                </div>
                            </a>
                        @endforeach
                        <span class="d-block text-center btn btn-default border-top border-left-0 border-right-0 border-bottom-0 border-secondary"><a href="{{ route('all_noti') }}" class="underline">View All</a></span>
                    </div>
                </div>
                <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="message"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-email"></i>
                    <span class="count bg-primary">9</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="message">
                        <p class="red">You have 4 Mails</p>
                        <a class="dropdown-item media bg-flat-color-1" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ asset('images/avatar/1.jpg') }}"></span>
                            <span class="message media-body">
                                <span class="name float-left">Jonathan Smith</span>
                                <span class="time float-right">Just now</span>
                                <p>Hello, this is an example msg</p>
                            </span>
                        </a>
                        <a class="dropdown-item media bg-flat-color-4" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ asset('images/avatar/2.jpg') }}"></span>
                            <span class="message media-body">
                                <span class="name float-left">Jack Sanders</span>
                                <span class="time float-right">5 minutes ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </span>
                        </a>
                        <a class="dropdown-item media bg-flat-color-5" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ asset('images/avatar/3.jpg') }}"></span>
                            <span class="message media-body">
                                <span class="name float-left">Cheryl Wheeler</span>
                                <span class="time float-right">10 minutes ago</span>
                                <p>Hello, this is an example msg</p>
                            </span>
                        </a>
                        <a class="dropdown-item media bg-flat-color-3" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ asset('images/avatar/4.jpg') }}"></span>
                            <span class="message media-body">
                                <span class="name float-left">Rachel Santos</span>
                                <span class="time float-right">15 minutes ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="user-avatar rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="User Avatar">
                </a>
                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>
                    <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>
                    <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>
                    <a class="nav-link" href="{{ route('login.logout') }}"><i class="fa fa-power -off"></i>Logout</a>
                </div>
            </div>
            <div class="language-select dropdown" id="language-select">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                <i class="flag-icon flag-icon-us"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="language" >
                    <div class="dropdown-item">
                        <span class="flag-icon flag-icon-fr"></span>
                    </div>
                    <div class="dropdown-item">
                        <i class="flag-icon flag-icon-es"></i>
                    </div>
                    <div class="dropdown-item">
                        <i class="flag-icon flag-icon-us"></i>
                    </div>
                    <div class="dropdown-item">
                        <i class="flag-icon flag-icon-it"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
    jQuery('.for-notification').on('click','.msg_read', function(e) {
        var noti_id = (jQuery(this).closest('.msg_read').find('.noti_id').val());
        jQuery('#smallmodal').modal('show');
        var route = "{{ route('noti.read', 'item') }}";
        var getData = {};
        jQuery.ajax({
            method: "GET",
            dataType: "json",
            url: route.replace('item', noti_id),         
            success: function(getData) {
                jQuery('.noti_count').html(getData.noti_count);
            }
        });
    });
</script>
<!-- /header -->
<!-- Header-->