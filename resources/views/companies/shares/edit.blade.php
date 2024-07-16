<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Shares</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_shares" action="{{ url('shares/update-shares', $share->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Collection Center <span class="text-danger">*</span></label>
                            <select name="center_id" id="center_id" class="select form-control" required readonly>
                                <option>Select Center</option>
                                @foreach($centers as $center)
                                <option value="{{$center->id}}" @if($share->center_id == $center->id) selected @endif>{{$center->center_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Farmer <span class="text-danger">*</span></label>
                            <select name="farmer_id" id="farmer_id" class="select form-control" required readonly>
                                <option>Select Farmer</option>
                                @if(isset($share->farmer_id))
                                    @foreach($farmers as $farmer)
                                        @if($farmer->center_id == $share->center_id)
                                            <option value="{{$farmer->id}}" @if($share->farmer_id == $farmer->id) selected @endif>{{$farmer->fname . ' ' . $farmer->lname}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Share Contribution <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="{{ $share->share_value }}" name="share_value" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Issue Date <span class="text-danger"></span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="{{ $share->issue_date }}" name="issue_date" type="text" >
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Mode of Contribution <span class="text-danger">*</span></label>
                            <select name="mode_of_contribution" class="select form-control" required>
                                <option value="">Select Mode of Contribution</option>
                                <option value="cash" @if($share->mode_of_contribution == 'cash') selected @endif>Cash</option>
                                <option value="milk" @if($share->mode_of_contribution == 'milk') selected @endif>Milk Deduction</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Description <span class="text-danger"></span></label>
                            <textarea class="form-control" name="description" rows="4">{{ $share->description }}</textarea>
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
    var selectedCenterId = $('#center_id').val();
    if(selectedCenterId) {
        fetchFarmers(selectedCenterId, {{ $share->farmer_id ?? 'null' }});
    }

    $('#center_id').change(function(){
        var centerId = $(this).val();
        if(centerId) {
            fetchFarmers(centerId, null);
            $('#farmer_id').prop('readonly', false);
        } else {
            $('#farmer_id').empty();
            $('#farmer_id').append('<option>Select Farmer</option>');
            $('#farmer_id').prop('readonly', true);
        }
    });

    function fetchFarmers(centerId, selectedFarmerId) {
        $.ajax({
            url: '/getFarmersByCenter/' + centerId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#farmer_id').empty();
                $('#farmer_id').append('<option>Select Farmer</option>');
                $.each(data, function(key, value) {
                    var selected = selectedFarmerId && selectedFarmerId == value.id ? 'selected' : '';
                    $('#farmer_id').append('<option value="'+ value.id +'" '+ selected +'>' + value.fname + ' ' + value.lname + '</option>');
                });
            }
        });
    }
});

$(document).ready(function(){
        
    $('#edit_shares').on('submit', function (e) {
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
                shares_table.ajax.reload();
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