<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Payment for {{$agent->name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="add_payment_form" action="{{url('/superadmin/pay')}}" method="POST">
                @csrf
                <input class="form-control" type="text" name="agent_id" value="{{$agent->id}}" hidden required>
                <div class="row">
                    <div class="col-sm-4">
                        <h5 class="text-danger">Total Commission: {{@num_format(\App\Models\Agent::calculatecommission($agent->id))}}</h5>
                    </div>

                    <div class="col-sm-4">
                        <h5 class="text-danger">Total Paid: {{@num_format(\App\Models\Agent::calculatePaid($agent->id))}}</h5>
                    </div>

                    <div class="col-sm-4">
                        <h5 class="text-danger">Total Balance: {{@num_format(\App\Models\Agent::calculateBalance($agent->id))}}</h5>
                    </div>
                </div>
                <hr>
                <div class="row">                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Date</label>
                            <div class="cal-icon">
                                <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="date" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Amount <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" max="{{\App\Models\Agent::calculateBalance($agent->id)}}" name="amount"  required>
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
    $(document).ready(function(){
            
        $('#add_payment_form').on('submit', function (e) {
            e.preventDefault();
            
            $(".submit-btn").html("Please wait...").prop('disabled', true);
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
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    agents_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                    $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                }
                $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
            });
        });
    });
    </script>