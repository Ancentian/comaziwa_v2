		
<!-- Bootstrap Core JS -->
<script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>

<!-- Slimscroll JS -->
<script src="<?php echo e(asset('js/jquery.slimscroll.min.js')); ?>"></script>

<!-- Chart JS -->
<script src="<?php echo e(asset('plugins/morris/morris.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/raphael/raphael.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/Chart.min.js')); ?>"></script>



<!-- Select2 JS -->
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<!-- Datetimepicker JS -->
<script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>

<!-- Calendar JS -->

<script src="<?php echo e(asset('js/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.fullcalendar.js')); ?>"></script>



<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>    
<!-- DataTables Buttons JavaScript -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<!-- Summernote JS -->
<script src="<?php echo e(asset('plugins/summernote/dist/summernote-bs4.min.js')); ?>"></script>
   
<!-- Sweet Alert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom JS -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    var ranges = {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment().endOf('year')],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    };

    // $(document).ready(function() {
    //         setInterval(function() {
    //             $.ajax({
    //                 url: '/check-internet',
    //                 type: 'GET',
    //                 success: function(response) {
    //                     console.log(response); // Debugging: Log the response to the console
    //                     if (response.status === 'restored') {
    //                         $('.internet-alert').text('Internet connection has been restored.').show();
    //                         toastr.success(response.status, 'Success');
    //                         setTimeout(function() {
    //                             $('.internet-alert').fadeOut();
    //                         }, 10000); // Hide alert after 10 seconds
    //                     } else if (response.status === 'lost') {
    //                         $('.internet-alert').text('Internet connection is lost.').show();
    //                         setTimeout(function() {
    //                             $('.internet-alert').fadeOut();
    //                         }, 10000); // Hide alert after 10 seconds
    //                     } else {
    //                         $('.internet-alert').hide();
    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.error('AJAX error:', status, error); // Debugging: Log any AJAX errors
    //                 }
    //             });
    //         }, 10000); // Check every 10 seconds
    //     });
  
        // $(document).ready(function() {
        //     setInterval(function() {
        //         $.ajax({
        //             url: '/check-internet',
        //             type: 'GET',
        //             success: function(response) {
        //                 console.log('Response:', response); // Debugging: Log the response to the console
        //                 if (response.status === 'restored') {
        //                     console.log('Internet restored');
        //                     $('#internet-alert').text('Internet connection has been restored.').addClass('alert-success').show();
        //                     setTimeout(function() {
        //                         $('.internet-alert').fadeOut();
        //                     }, 10000); // Hide alert after 10 seconds
        //                 } else if (response.status === 'lost') {
        //                     console.log('Internet lost');
        //                     $('#internet-alert').text('Internet connection is lost.').addClass('alert-danger').show();
        //                     setTimeout(function() {
        //                         $('.internet-alert').fadeOut();
        //                     }, 10000); // Hide alert after 10 seconds
        //                 } else if (response.status === 'unchanged') {
        //                     console.log('Internet status unchanged');
        //                     $('.internet-alert').hide();
        //                 } else {
        //                     console.log('Unknown status');
        //                     $('.internet-alert').hide();
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('AJAX error:', status, error); // Debugging: Log any AJAX errors
        //             }
        //         });
        //     }, 10000); // Check every 10 seconds
        // });

$(document).ready(function() {
    setInterval(function() {
        $.ajax({
            url: '/check-internet',
            type: 'GET',
            success: function(response) {
                // Select the alert element
                var alertElement = $('#internet-alert');
                if (response.status === 'restored') {
                    alertElement.removeClass('alert-danger').addClass('alert-success').text('Internet connection has been restored.').show();
                } else if (response.status === 'lost') {
                    alertElement.removeClass('alert-success').addClass('alert-danger').text('Internet connection is lost.').show();
                } else if (response.status === 'unchanged') { 
                    alertElement.hide();
                } else {  
                    alertElement.hide();
                }

                setTimeout(function() {
                    alertElement.fadeOut();
                }, 10000); // Hide alert after 10 seconds
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error); // Debugging: Log any AJAX errors
            }
        });
    }, 10000); // Check every 10 seconds
});



</script>

<?php /**PATH C:\laragon\www\comaziwa\resources\views/layout/footer.blade.php ENDPATH**/ ?>