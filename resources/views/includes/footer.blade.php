<div class="modal fade" id="reminder_Modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <input type="text" name="">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="to-top">
    <a href="#" class="back-to-top page-scroll target-scroll" style="display: block;">
    <i class="fa fa-angle-up"></i>
    </a>
</div>
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
        jQuery('.table-responsive').css( 'display','block' );
    }
</script>
<script type="text/javascript">
    function resetAllValues() {
        jQuery('input:text').val('');
        jQuery('textarea').val('');
        jQuery('select').val('');
        jQuery('input:email').val('');
        jQuery('input:checkbox').removeAttr('checked');
        jQuery("input[type=date]").val('');
    }
</script>
<script type="text/javascript">
    //jQuery to collapse the navbar on scroll
    jQuery(window).scroll(function() {
        if (jQuery(".navbar").offset().top > 50) {
            jQuery(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            jQuery(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });
</script>
<script type="text/javascript">
    jQuery('body').on('click', '.msg_read', function(e) {
        jQuery('#myModal').modal('show');
    });
</script>
