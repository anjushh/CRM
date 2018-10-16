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
    <a href="#header" class="back-to-top page-scroll target-scroll" style="display: block;">
    <i class="fa fa-angle-up"></i>
    </a>
</div>
@php $route = \Request::route()->getName(); @endphp
@if(($route == 'client.create') || ($route == 'company.create'))
    <script></script>
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endif
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smoothscroll/1.4.6/SmoothScroll.min.js"></script>
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
        jQuery('input[type=email]').val('');
        jQuery('input[type=password]').val('');
        jQuery('input:checkbox').removeAttr('checked');
        jQuery("input[type=date]").val('');
        jQuery('selector').datepicker('setDate', null);
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
<script type="text/javascript">
    jQuery('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
        
    });
</script>
<script type="text/javascript">
    jQuery("#datepicker1").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: new Date(),
            minDate: new Date(),
            onSelect: function(dateStr) 
            {         
                // jQuery("#datepicker2").val(dateStr);
                jQuery("#datepicker2").datepicker("option",{ minDate: new Date(dateStr)})

            }
        });
    jQuery('#datepicker2').datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: new Date(),
            onSelect: function(dateStr) {
            toDate = new Date(dateStr);
            jQuery("#datepicker3").datepicker("option",{ minDate: new Date(dateStr)})
            }
        });
    jQuery('#datepicker3').datepicker({
            dateFormat: "yy-mm-dd",
        defaultDate: new Date(),
        onSelect: function(dateStr) {
        toDate = new Date(dateStr);
        }
    });

    jQuery("#datepicker4").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: new Date(),
            minDate: new Date(),
            onSelect: function(dateStr) 
            {         
                // jQuery("#datepicker2").val(dateStr);
                jQuery("#datepicker5").datepicker("option",{ minDate: new Date(dateStr)})

            }
        });
    jQuery('#datepicker5').datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: new Date(),
            onSelect: function(dateStr) {
            toDate = new Date(dateStr);
            jQuery("#datepicker6").datepicker("option",{ minDate: new Date(dateStr)})
            }
        });
    jQuery('#datepicker6').datepicker({
            dateFormat: "yy-mm-dd",
        defaultDate: new Date(),
        onSelect: function(dateStr) {
        toDate = new Date(dateStr);
        }
    });
    
    jQuery('.datepick').each(function(){
        jQuery(this).datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

</script>
<script type="text/javascript">
    // Select all links with hashes
$('a[href*="#"]')
// Remove links that don't actually link to anything
.not('[href="#"]')
.not('[href="#0"]')
.click(function(event) {
// On-page links
if (
location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
&& 
location.hostname == this.hostname
) {
// Figure out element to scroll to
var target = $(this.hash);
target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
// Does a scroll target exist?
if (target.length) {
// Only prevent default if animation is actually gonna happen
event.preventDefault();
$('html, body').animate({
scrollTop: target.offset().top
}, 1000, function() {
// Callback after animation
// Must change focus!
var $target = $(target);
$target.focus();
if ($target.is(":focus")) { // Checking if the target was focused
return false;
} else {
$target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
$target.focus(); // Set focus again
};
});
}
}
});
</script>
