<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_category" action="{{ url('milk-management/update-consumer-category', $category->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Category Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{$category->name}}" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control select" name="status" required>
                                <option value="">Select Status</option>
                                <option value="1" @if($category->status == '1') selected @endif>Active</option>
                                <option value="0" @if($category->status == '0') selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="description">{{ $category->description }}</textarea>
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
            
        $('#edit_category').on('submit', function (e) {
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
                    consumer_categories_table.ajax.reload();
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