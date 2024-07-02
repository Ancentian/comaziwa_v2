<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form id="" >
                @csrf
                <div class="form-group">
                    <label>Email To:</label>
                    <input type="text" placeholder="To" value="{{$email->email}}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Subject:</label>
                    <input type="text" placeholder="Subject" value="{{$email->subject}}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    {!!$email->message!!}
                </div>
                
            </form>
            
        </div>
    </div>
</div>