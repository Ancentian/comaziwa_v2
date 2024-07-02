<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit_package_form" action="{{ url('packages/update', [$package->id]) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Name <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{ $package->name }}" type="text">
            <span class="modal-error invalid-feedback" role="alert"></span>
          </div>
          <div class="form-group">
            <label>Monthly Price<span class="text-danger">*</span></label>
            <input class="form-control" @if($package->is_system ==1) max="0"  @endif name="price" value="{{ $package->price }}" type="number">
            <span class="modal-error invalid-feedback" role="alert"></span>
          </div>
          
          <div class="form-group">
            <label>Annual Price<span class="text-danger">*</span></label>
            <input class="form-control" name="annual_price"  @if($package->is_system ==1) max="0"  @endif value="{{ $package->annual_price }}" type="number">
            <span class="modal-error invalid-feedback" role="alert"></span>
          </div>
          
          <div class="form-group">
            <label>No of Staff<span class="text-danger">*</span></label>
            <input class="form-control" name="staff_no" value="{{ $package->staff_no }}" type="number">
            <span class="modal-error invalid-feedback" role="alert"></span>
          </div>
            <div class="form-group ml-4">
                <input class="form-check-input" type="checkbox" name="is_hidden" value="1" {{ $package->is_hidden == 1 ? 'checked' : '' }}>
                <label class="mr-2">Is Hidden<span class="text-danger"></span></label>
                <span class="modal-error invalid-feedback" role="alert"></span>
            </div>


          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module1" value="hr">
                  <label class="form-check-label" for="module1">
                    HR (Employee Management)
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module2" value="payroll">
                  <label class="form-check-label" for="module2">
                    Payroll
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module3" value="attendance">
                  <label class="form-check-label" for="module3">
                    Attendance
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module4" value="contracts">
                  <label class="form-check-label" for="module4">
                    Contracts
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module5" value="leaves">
                  <label class="form-check-label" for="module5">
                    Leaves
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module6" value="projects">
                  <label class="form-check-label" for="module6">
                    Projects
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module7" value="tasks">
                  <label class="form-check-label" for="module7">
                    Tasks
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module8" value="bulky_sms">
                  <label class="form-check-label" for="module8">
                    Bulky SMS
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]" id="module9" value="bulky_email">
                  <label class="form-check-label" for="module9">
                    Bulky Email
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]"  id="module10" value="expenses">
                  <label class="form-check-label" for="module10">
                    Expenses
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="module[]"  id="module11" value="trainings">
                  <label class="form-check-label" for="module11">
                    Trainings
                  </label>
                </div>
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
    $("#edit_package_form").submit(function(e) {
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
                packages_table.ajax.reload();
                $('#edit_modal').modal('hide');
                location.reload(); // Reload the page
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function(xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
                console.log(xhr.responseText);
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        });
    });


        $(document).ready(function() {
        // Retrieve the list of modules
        var modules = {!! json_encode($package->module) !!};

        // Loop through the checkboxes and check if the module exists in the list
        $('input[name="module[]"]').each(function() {
            var moduleValue = $(this).val();
            if (modules.includes(moduleValue)) {
            $(this).prop('checked', true);
            }
        });
    });
</script>