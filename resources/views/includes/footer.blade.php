@php $route = \Request::route()->getName(); @endphp
@if(($route == 'client.create') || ($route == 'company.create'))
    <script></script>
@else
    <script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
@endif

<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    if(window.outerWidth < 480) {
        $('.table-responsive').css( 'display','block' );
    }
</script>
<script type="text/javascript">
    function resetAllValues() {
        jQuery('.form-group').find('input:text').val('');
    }
</script>
