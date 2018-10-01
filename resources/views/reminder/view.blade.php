@extends('layouts.dashboard')
@section('content')

<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
    jQuery(window).on('load',function(){
        jQuery('#smallmodal').modal('show');
    });
</script>
@endsection