<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Milk Collection</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_milk_collection" action="{{ url('milkCollection/update-milk-collection', $milk->id) }}" method="POST">
                @csrf
                <div class="row">
                    
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Collection Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control date" name="collection_date" value="{{$milk->collection_date}}" required>
                            </div>
                        </div>
                    </div>   
                </div>
                <div id="course_details">            
                    <div class="row">
                        <h4 class="text-center w-100">Edit Milk Collection</h4>
                        <div class="col-md-12">
                            <table class="table table-striped custom-table mb-0" id="edit_collection_table">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Morning</th>
                                        <th>Evening</th> 
                                        <th>Rejected</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" value="{{$farmer->farmerID}}" readonly></td>
                                        <td><input type="number" class="form-control morning" step="any" name="morning" value="{{$milk->morning}}" id="farmerid" ></td>
                                        <td><input type="number" class="form-control evening" step="any" name="evening" value="{{$milk->evening}}" id="evening" ></td>
                                        <td><input type="number" step="any" class="form-control rejected" name="rejected" value="{{$milk->rejected}}" id="reject" ></td>
                                        <td><input type="number" step="any" class="form-control total" name="total" value="{{$milk->total}}" id="total" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#edit_milk_collection').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    collected_milk_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });

        $("#edit_collection_table tbody").on("input", ".morning, .evening, .rejected", function () {
            var $row = $(this).closest("tr");
            var morning = parseFloat($row.find(".morning").val()) || 0;
            var evening = parseFloat($row.find(".evening").val()) || 0;
            var rejected = parseFloat($row.find(".rejected").val()) || 0;
            var total = $row.find(".total");
            total.val((morning + evening) - rejected);
            //calc_total();
        });
    });
</script>