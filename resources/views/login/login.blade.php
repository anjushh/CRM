@include ('includes.head')
<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="{{ asset('assets/images/logo.png')}}" alt="">
                    </a>
                </div>
                <div class="col-12">
                    @if ($message = Session::get('logout'))
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show mt-3">
                            <span class="badge badge-pill badge-danger">logged out</span>
                                {{ $message }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('failed'))
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show mt-3">
                            <span class="badge badge-pill badge-danger">Failed</span>
                                {{ $message }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="login-form">
                    {!! Form::open(array('route' => 'login.loginstore','method'=>'POST','files'=>true)) !!}
                    <div class="form-group">
                        <label>User Name</label>
                        {!! Form::email('email', null, array('placeholder' => 'Enter Email','class' => 'form-control')) !!}
                        {{ $errors->has('username') ? 'Username should be in Valid Format': '' }}
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        {!! Form::password('password', array('class' => 'form-control','placeholder' => 'Enter Password')) !!}
                        {{ $errors->has('password') ? 'Password should be alleast of 8 characters': '' }}
                    </div>
                    <!-- <div class="checkbox">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                        <label class="pull-right">
                            <a href="#">Forgotten Password?</a>
                        </label>

                    </div> -->
                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                    <!-- <div class="social-login-content">
                            <div class="social-button">
                                <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i class="ti-facebook"></i>Sign in with facebook</button>
                                <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Sign in with twitter</button>
                            </div>
                        </div>
                    <div class="register-link m-t-15 text-center">
                        <p>Don't have account ? <a href="{{ route('login.register') }}
"> Sign Up Here</a></p>
                    </div> -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>