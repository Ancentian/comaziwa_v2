<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Taxbands</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{url('taxbands/updateTaxband',[$taxband->id])}}" method="POST" id="edit_taxband_form">
                @csrf
                <div class="form-group">
                    <label>Minimum <span class="text-danger">*</span></label>
                    <input class="form-control" name="min" value="{{$taxband->min}}"  type="number">
                </div>
                <div class="form-group">
                    <label>Maximum <span class="text-danger">*</span></label>
                    <input class="form-control" name="max" value="{{$taxband->max}}" type="number">
                </div>
                <div class="form-group">
                    <label>Rate<span class="text-danger">*</span></label>
                    <input class="form-control" name="rate" value="{{$taxband->rate}}" type="number">
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_taxband_form").submit(function(e){
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
                    contract_types_table.ajax.reload();
                    tax_bands_table.ajax.reload();
                    $('#edit_modal').modal('hide');
                    toastr.success(response.message, 'Success');
                    $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
                $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
            });

        });
</script>