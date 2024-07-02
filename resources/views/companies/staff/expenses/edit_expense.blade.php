<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Expense</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_expense_form" action="{{ url('expenses/update-staff-expense', [$expense->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Expense Type </label>
                            <select class="select form-control" name="type_id">
                                @foreach ($expense_types as $key)
                                    <option value="{{ $key->id }}" {{ $key->id === $expense->id ? 'selected' : '' }}>{{ $key->name }}</option>
                                @endforeach
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Date</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="date" value="{{$expense->purpose}}"  type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Purpose</label>
                            <textarea class="form-control" name="purpose" id="" cols="30" rows="3">{{$expense->purpose}}</textarea>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount</label>
                            <input placeholder="" class="form-control" name="amount" value="{{$expense->amount}}" type="text">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn"><span id="submit_form">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_expense_form").submit(function(e) {
    e.preventDefault();
    
    $("#submit_form").html("Please wait...").prop('disabled', true);
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(response) {
            
            $('#expense_modal').modal('hide');
            staff_expenses_table.ajax.reload();
            toastr.success(response.message, 'Success');
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
});

</script>
