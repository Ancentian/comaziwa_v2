<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Comments</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_category" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Comments <span class="text-danger">*</span></label>
                            <textarea name="" id="" class="form-control" cols="10" rows="5">{{ $comment = $comment ?? 'No comment'; }}</textarea>
                        </div>
                    </div>   
                </div>
                <div class="submit-section" hidden>
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>