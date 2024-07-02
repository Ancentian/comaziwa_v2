<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Mail Template</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form id="" >
                @csrf
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" placeholder="Subject" value="{{$email->name}}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    {!!$email->template!!}
                </div>
                
            </form>
            
        </div>
    </div>
</div>