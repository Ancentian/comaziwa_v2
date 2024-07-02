<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Employee Groups</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_employees_group_form" action="{{url('employees/update_employeesGroup',[$employeeGroup->id])}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name<span class="text-danger">*</span></label>
                    <input class="form-control" name="name" value="{{$employeeGroup->name}}" type="text">
                </div>
                <div class="form-group">
                    <label>Minimum Salary<span class="text-danger">*</span></label>
                    <input class="form-control" name="min_salary" value="{{$employeeGroup->min_salary}}" type="number">
                </div>
                <div class="form-group">
                    <label>Maximum Salary<span class="text-danger">*</span></label>
                    <input class="form-control" name="max_salary" value="{{$employeeGroup->max_salary}}" type="number">
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_employees_group_form").submit(function(e){
            e.preventDefault();

            $(".submit-btn").html("Please wait...").prop('disabled', true);
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    employees_group_table.ajax.reload();
                    $('#edit_modal').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });

        });
</script>