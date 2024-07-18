<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Shares Configuration</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_shares_settings" action="{{ url('shares/update-shares-settings', $setting->id) }}" method="POST">
                @csrf
                <div class="row"> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Share Name<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="{{$setting->shares_name}}" name="shares_name" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Share Contribution <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="{{$setting->deduction_amount}}" name="deduction_amount" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Accumulative Contribution <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="{{$setting->accumulative_amount}}" name="accumulative_amount" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                     
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Description <span class="text-danger"></span></label>
                            <textarea class="form-control" name="description" rows="4">{{ $setting->description }}</textarea>
                        </div>
                    </div>                  
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
        
    $('#edit_shares_settings').on('submit', function (e) {
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
                shares_settings_table.ajax.reload();
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        });
    });
});
</script>