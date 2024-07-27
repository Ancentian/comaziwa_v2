<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Transaction Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Order Date</th>
                            <th>Unit Cost</th>
                            <th>Quantity</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody id="transactionDetailsBody">
                        <!-- Details will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
   

    $(document).ready(function(){
    // Attach event listener to the button or link that triggers the modal
    $(document).on('click', '.view-transaction-details', function() {
        var transactionId = $(this).data('transaction-id');
        
        $.ajax({
            url: "{{url('sales/transaction-details')}}"+"/"+ transactionId,
            method: 'GET',
            success: function(response) {
                // Clear previous details
                $('#transactionDetailsBody').empty();
                
                // Append new details
                $.each(response, function(index, detail) {
                    $('#transactionDetailsBody').append('<tr>' +
                        '<td>' + detail.item_name + '</td>' +
                        '<td>' + detail.order_date + '</td>' +
                        '<td>' + detail.unit_cost + '</td>' +
                        '<td>' + detail.qty + '</td>' +
                        '<td>' + detail.total_cost + '</td>' +
                    '</tr>');
                });

                // Show the modal
                $('#transactionDetailsModal').modal('show');
            },
            error: function(response) {
                console.log(response);
                alert('Error fetching details.');
            }
        });
    });
});
</script>

</script>