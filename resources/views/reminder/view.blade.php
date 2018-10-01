@extends('layouts.dashboard')
@section('content')
	    <div class="alert alert-success">
	       	<div class="modal fade show" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" style="display: block; padding-right: 17px;">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Small Modal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    {{ $alert }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
	    </div>
<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
    jQuery(window).on('load',function(){
        jQuery('#smallmodal').modal('show');
    });
</script>
@endsection