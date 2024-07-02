<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form id="" >
                @csrf
                <div class="form-group">
                    <label>Request By:</label>
                    <input type="text" placeholder="To" value="{{$expense->employeeName}}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Amount:</label>
                    <input type="text" placeholder="To" value="{{$expense->amount}}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" placeholder="To" value="{{$expense->date}}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Purpose:</label> <br>
                    {!!$expense->purpose!!}
                </div>
                
            </form>
            
        </div>
    </div>
</div>