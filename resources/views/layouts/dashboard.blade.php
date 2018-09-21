<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
  @include('includes.head')
</head>
<body>
    <aside id="left-panel" class="left-panel">
        @include('includes.leftbar')
    </aside>
    <div id="right-panel" class="right-panel">
        @include('includes.header')
       <section class="content p-0">
            <div class="container clearfix p-0">
                <div class="content mt-3 p-0">
                    @yield('content')
                </div>
            </div>
        </section>
    </div>
    @include('includes.footer')
</body>
</html>
