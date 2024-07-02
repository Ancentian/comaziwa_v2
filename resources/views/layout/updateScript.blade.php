<script>
    $(document).ready(function () {
    $('#edit_contract').on('submit', function (e) {
        e.preventDefault();

        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('employees/update_employeesGroup') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();

                // Close the modal
                $('#edit_empGroupModal').modal('hide');
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(error);
            }
        });
    });

    // When the Edit button is clicked, populate the form fields with the data to be edited
    $(document).on('click', '[data-target="#edit_empGroupModal"]', function () {
        var employeeId = $(this).data('id');
        var employeeName = ''; // Get the existing data for the employee's name or any other field

        $('#edit_employee_id').val(employeeId);
        $('#edit_employee_name').val(employeeName);
        // Populate other form fields as needed
    });
});

</script>