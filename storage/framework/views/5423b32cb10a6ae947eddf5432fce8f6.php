

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Sales Transactions</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Date Range <span class="text-danger">*</span></label>
            <input type="text" readonly id="daterange" class="form-control" value="<?php echo e(date('m/01/Y')); ?> - <?php echo e(date('m/t/Y')); ?>" />
        </div>
    </div>
    <div class="form-group col-sm-4">
        <label for="center_id">Select Center</label>
        <select class="form-control select" name="center_id" id="center_id" required>
            <option value="">Choose one</option>
            <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($center->id); ?>"><?php echo e($center->center_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group col-sm-4">
        <label for="farmer_id">Select Farmer</label>
        <select class="form-control select" name="farmer_id" id="farmer_id" required>
            <option value="">Choose one</option>
        </select>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane show active" id="all_sales">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table" id="all_transactions_table">
                    <thead>
                        <tr>
                            <th class="text-left no-sort">Action</th>
                            <th>Transaction ID</th>
                            <th>Farmer</th>
                            <th>Center</th>
                            <th>Items</th>
                            <th>Total Cost</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Transaction data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
$(document).ready(function() {
    $('#daterange').daterangepicker({
        opens: 'bottom',
        ranges: ranges
    }, function(start, end, label) {
        all_transactions_table.ajax.reload();
    });

    $(document).on('change', '#center_id, #farmer_id', function () {
        all_transactions_table.ajax.reload();
    });

    var all_transactions_table = $('#all_transactions_table').DataTable({
        <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        processing: true,
        serverSide: false,
        ajax: {
            url: "<?php echo e(url('sales/all-transactions')); ?>",
            data: function(d) {
                // Access the start and end dates from the date range picker
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                
                // Add the dates as parameters to the request
                d.start_date = startDate;
                d.end_date = endDate;
                d.center_id = $("#center_id").val();
                d.farmer_id = $("#farmer_id").val();
            }
        },
        columnDefs: [{
            "targets": 1,
            "orderable": false,
            "searchable": false
        }],
        columns: [
            {data: 'action', name: 'action', className: 'text-left'}, 
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'fullname', name: 'fullname'},
            {data: 'center_name', name: 'center_name'},
            {data: 'item_count', name: 'item_count'},
            {data: 'total_cost', name: 'total_cost'},
            {data: 'order_date', name: 'order_date'},
        ],
        createdRow: function(row, data, dataIndex) {
            // Custom row creation logic
        }
    });

    $('#center_id').on('change', function() {
        var centerId = $(this).val();

        // Clear farmer details and farmer select options
        $('#farmer_id').val('');
        $('#farmer_name').val('');
        $('#farmer_id').empty().append('<option value="">Choose one</option>');

        if (centerId) {
            $.ajax({
                url: '/sales/getFarmersByCenter/' + centerId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#farmer_id').append('<option value="'+ value.id +'">'+ value.fname +' '+ value.lname +' - '+ value.farmerID +'</option>');
                    });
                },
                error: function() {
                    alert('Failed to retrieve farmers. Please try again.');
                }
            });
        }
    });

    $('#farmer_id').on('change', function() {
        var farmerId = $(this).val();

        if (farmerId) {
            $.ajax({
                url: '/sales/getFarmerDetails/' + farmerId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#farmer_id').val(data.id);
                    $('#farmer_code').val(data.farmerID);
                    $('#farmer_name').val(data.fname + ' ' + data.lname);
                    // Add more fields as necessary
                },
                error: function() {
                    alert('Failed to retrieve farmer details. Please try again.');
                }
            });
        } else {
            $('#farmer_id').val('');
            $('#farmer_name').val('');
        }
    });
});

$(document).on('click', '.print-report', function (e) {
            e.preventDefault();

            var url = $(this).data('href');
            var action = $(this).data('string');
            console.log(url);
            $.ajax({
                url: url, 
                method: 'GET', 
                dataType: 'html',           
                success: function (response) {
                
                    if(action == 'print'){
                        // $("#print_content").html(response);
                        // $('#print_content').show().printThis({
                        //     importCSS: true,
                        //     afterPrint: function() {
                        //         $('#print_content').hide();
                        //     }
                        // });
                        var pdfUrl = JSON.parse(response).pdfUrl;
                        console.log(pdfUrl);
                        $("#pdfViewer").attr("src", pdfUrl);

                        // Show the embed once the PDF is loaded
                        $("#pdfViewer").on("load", function() {
                            $(this).show();
                
                            // Trigger the print function once the PDF is loaded
                            window.frames['pdfViewer'].focus();
                            window.frames['pdfViewer'].print();
                        });

                    }else{
                        var pdfUrl = JSON.parse(response).pdfUrl;
                        window.open(pdfUrl, '_blank');
                    }
                    

                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
   
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/sales/all-transactions.blade.php ENDPATH**/ ?>