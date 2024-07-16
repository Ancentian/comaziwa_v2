<script>
    function paysubscription(amount,plan,type){
            
            let handler = PaystackPop.setup({
                key: "{{env('PAYSTACK_KEY')}}", // Replace with your public key
                email: "{{auth()->user()->email}}",
                amount: amount * 100,
                currency: 'GHS',
                ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                // label: "Optional string that replaces customer email"
                onClose: function(){
                    toastr.error('Payment cancelled','Error');
                },
                callback: function(response){
                    console.log(response);
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{url('dashboard/confirm-payment')}}/"+response.reference+"/"+plan, 
                        method: 'GET',
                        data: {type},
                        headers: {
                            'X-CSRF-TOKEN': token 
                        },
                        success: function (response) {
                            console.log(response);
                            // Handle success response
                            toastr.success('Payment successful','Success');
                            window.location.reload();
                        },
                        error: function (xhr, status, error) {
                            // Handle error response
                            console.error(error);
                            toastr.error('Something Went Wrong!, Try again!','Error');
                        }
                    });
                }
            });

            handler.openIframe();
        }

    $(document).ready(function () {    
    //Save Salary Types
    $('#salaryType').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('salaries/store_salaryType') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();
                salary_types_table.ajax.reload();
                // Close the modal
                $('#add_salary').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Allowance
    $('#allowance_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('allowances/store_allowance') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();

                allowances_table.ajax.reload();
                
                // Close the modal
                $('#add_allowance').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    $('#contract_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('departments/store') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();

                contract_types_table.ajax.reload();
                
                // Close the modal
                $('#add_contractType').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Deductions
    $('#deduction').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('deductions/store_deduction') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();
                deductions_table.ajax.reload();
                // Close the modal
                $('#create_deduction').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Collection Center
    $('#addColectionCenter').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('centers/store-collection-center') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(formData);
                form.reset();

                collection_centers_table.ajax.reload();
                
                // Close the modal
                $('#add_collection_center').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Cooperative Bank
    $('#bankForm').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('cooperative/store-banks') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                banks_table.ajax.reload();
                
                // Close the modal
                $('#add_bank').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });
    
    $('#leaveTypesFrm').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('leave-types/store') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(formData);
                form.reset();

                leave_types_table.ajax.reload();
                
                // Close the modal
                $('#add_leave_type').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Statutory Deductions
    $('#statutoryDeduction').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('deductions/store_statutoryDeduction') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();
                
                statutory_table.ajax.reload();
                
                // Close the modal
                $('#add_statutoryDed').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Non Statutory Deductions
    $('#nonStatutoryDeduction').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('deductions/store_nonStatutoryDeduction') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();

                non_statutory_table.ajax.reload();
                
                // Close the modal
                $('#add_nonStatutory').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Employee Groups
    $('#emp_groupForm').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('employees/store_employeesGroup') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();

                employees_group_table.ajax.reload();
                
                // Close the modal
                $('#add_empGroup').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

    //Save Employee Groups
    $('#package_form').on('submit', function (e) {
    e.preventDefault();
    
    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('packages/store') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            // Handle success response
            console.log(response);
            form.reset();

            packages_table.ajax.reload();

            // Close the modal
            $('#add_package').modal('hide');
            toastr.success(response.message, 'Success');
            // Reload the whole page
            location.reload();
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        }
    });
});


    //Save Tenant Subscription Groups
    $('#subscription_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('superadmin/store') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                form.reset();

                subscriptions_table.ajax.reload();
                
                // Close the modal
                $('#add_subscription').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });


    //Save Leave Data
    $('#add_leave_form').on('submit', function (e) {
    e.preventDefault();
    
    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('leaves/store') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            // Handle success response
            form.reset();

            leaves_table.ajax.reload();
            $('#add_leave').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        }
    });
});

//Save Other Staff Leave Data
$('#add_staff_leave_form').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('staff/store-staff-leave') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            // Handle success response
            form.reset();

            staff_leaves_table.ajax.reload();
            $('#add_staff_leave').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
    });
});

//Save Leave Data
$('#add_emp_leave_form').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();
    var dateFrom = $('[name="date_from"]').val();
    var dateTo = $('[name="date_to"]').val();
    var remainingDays = parseInt($('[name="remaining_days"]').val());

    var diffInDays = calculateDateDifference(dateFrom, dateTo);
    
    if (diffInDays > remainingDays) {
        toastr.error('You only have ' + remainingDays + ' leave days remaining', 'Error');
        return;
    }

    $.ajax({
        url: '{{ url('staff/storeLeave') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            // Handle success response
            form.reset();

            emp_leaves_table.ajax.reload();

            $('#add_emp_leave').modal('hide');
            toastr.success(response.message, 'Success');
            window.location.reload();
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        }
    });
});

function calculateDateDifference(dateFrom, dateTo) {
    var startDate = new Date(dateFrom);
    var endDate = new Date(dateTo);
    var diffInMilliseconds = Math.abs(endDate - startDate);
    var diffInDays = Math.ceil(diffInMilliseconds / (1000 * 60 * 60 * 24));
    return diffInDays;
}

//Upload Contract Data
$('#upload_contract_file').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = new FormData(form);

    $.ajax({
        url: '{{ url('contracts/storeContract') }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            // Handle success response
            form.reset();
            location.reload();
            $('#upload_contract').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
    });
});

//Send Mail To Many
$('#send_mail_form').on('submit', function (e) {
        e.preventDefault();

        $("#submit_send_email").html("Please wait...");

        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('communications/sendMail') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                form.reset();

                outbox_table.ajax.reload();

                $("#submit_send_email").html("Send");
                
                // Close the modal
                $('#send_mail').modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        }
        });
    });

    //Staff Send Mail To Many
$('#staff_send_mail_form').on('submit', function (e) {
        e.preventDefault();

        $("#submit_send_email").html("Please wait...");

        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('staff/sendMail') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                form.reset();

                outbox_table.ajax.reload();

                $("#submit_send_email").html("Send");
                
                // Close the modal
                $('#staff_send_mail').modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        }
        });
    });

    //Send Mail To Bulky
    $('#send_bulky_mail_form').on('submit', function (e) {
        e.preventDefault();
    
        $("#submit_send_email").html("Please wait...");
    
        var form = this;
        var formData = new FormData(form); // Create a FormData object to handle file uploads
    
        $.ajax({
            url: '{{ url('communications/send_bulkyEmails') }}',
            method: 'POST',
            data: formData,
            contentType: false, // Set contentType to false to allow proper handling of the FormData
            processData: false, // Set processData to false to prevent jQuery from transforming the data into a query string
            success: function (response) {
                form.reset();
    
                outbox_table.ajax.reload();
    
                $("#submit_send_email").html("Send");
                
                // Close the modal
                $('#send_mail').modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
               var responseJSON = xhr.responseJSON;
                if (responseJSON && responseJSON.errors) {
                    // Display validation errors
                    var errors = responseJSON.errors;
                    Object.keys(errors).forEach(function (field) {
                        var errorMessage = errors[field][0];
                        var fieldElement = $('[name="' + field + '"]');
                        var errorElement = fieldElement.next('.modal-error');
                        fieldElement.addClass('is-invalid');
                        errorElement.text(errorMessage).show();
                        toastr.error(errorMessage,'Error');
                    });
                    // Prevent modal closure if there are errors
                    return false;
                }else{
                    
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            }
        });
    });

    //Staff Send Mail To Bulky
    $('#staff_send_bulky_mail_form').on('submit', function (e) {
        e.preventDefault();
    
        $("#submit_send_email").html("Please wait...");
    
        var form = this;
        var formData = new FormData(form); // Create a FormData object to handle file uploads
    
        $.ajax({
            url: '{{ url('communications/send_bulkyEmails') }}',
            method: 'POST',
            data: formData,
            contentType: false, // Set contentType to false to allow proper handling of the FormData
            processData: false, // Set processData to false to prevent jQuery from transforming the data into a query string
            success: function (response) {
                form.reset();
    
                outbox_table.ajax.reload();
    
                $("#submit_send_email").html("Send");
                
                // Close the modal
                $('#staff_bulk_send_mail').modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
               var responseJSON = xhr.responseJSON;
                if (responseJSON && responseJSON.errors) {
                    // Display validation errors
                    var errors = responseJSON.errors;
                    Object.keys(errors).forEach(function (field) {
                        var errorMessage = errors[field][0];
                        var fieldElement = $('[name="' + field + '"]');
                        var errorElement = fieldElement.next('.modal-error');
                        fieldElement.addClass('is-invalid');
                        errorElement.text(errorMessage).show();
                        toastr.error(errorMessage,'Error');
                    });
                    // Prevent modal closure if there are errors
                    return false;
                }else{
                    
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            }
        });
    });
    
    $('#import_milk_form').on('submit', function (e) {
        e.preventDefault();
    
        $("#btn_milk_import").html("Please wait...");
    
        var form = this;
        var formData = new FormData(form);
    
        $.ajax({
            url: '{{ url('milkCollection/store-import-milk') }}',
            method: 'POST',
            data: formData,
            contentType: false, 
            processData: false,
            success: function (response) {
                form.reset();
                employees_table.ajax.reload();
                $("#btn_milk_import").html("Import");
                $('#import').modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = errors;
            
                    toastr.error(errorMessage, 'Validation Errors');
                } else {
                    toastr.error('Something Went Wrong!, Try again!', 'Error');
                }
            }
        });
    });

//Save Client Data
$('#add_clients').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('superadmin/create-users') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();

            clients_table.ajax.reload();
            $('#add_user').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        }
    });
});

//Save Admin Data
$('#add_admin').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('superadmin/create-admin') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();

            users_table.ajax.reload();
            $('#add_user').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
    });
});

$('#add_role').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('superadmin/create-role') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();
            roles_table.ajax.reload();
            $('#add_user').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
    });
});

//Save Expenses Type Data
$('#expense_type_form').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('expenses/store-expenses-type') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();

            expense_types_table.ajax.reload();
            $('#add_expense_type').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
    });
});

//Save Expenses Data
$('#add_expense_form').on('submit', function (e) {
    e.preventDefault();
    
    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('expenses/store-staffExpenseRequest') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();

            staff_expenses_table.ajax.reload();
            $('#add_expense').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        }
    });
});


//Save Email Templates Data
$('#create_template_form').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('communications/create-email-template') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();

            templates_table.ajax.reload();
            $('#create_template').modal('hide');
            toastr.success(response.message, 'Success');
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
        }
    });
});

//Create Staff Email Templates Data
$('#staff_create_template_form').on('submit', function (e) {
    e.preventDefault();

    $(".submit-btn").html("Please wait...").prop('disabled', true);
    var form = this;
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ url('staff/create-email-template') }}',
        method: 'POST',
        data: formData,
        success: function (response) {
            form.reset();

            staff_templates_table.ajax.reload();
            $('#staff_create_template').modal('hide');
            toastr.success(response.message, 'Success');
        },
        error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        }
    });
});



    $(document).on('click', '.delete-button', function () {
        var actionuRL = $(this).data('action');
        console.log(actionuRL);
        $("#modal_delete_action").val(actionuRL);
        $("#delete_modal").modal('show');
    });

    $(document).on('click', '.delete-reload-button', function () {
        var actionuRL = $(this).data('action');
        console.log(actionuRL);
        $("#modal_delete_reload_action").val(actionuRL);
        $("#delete_reload_modal").modal('show');
    });


    $(document).on('click', '.edit-button', function () {
        var actionuRL = $(this).data('action');

        $('#edit_modal').load(actionuRL, function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.leave-edit-button', function () {
        var actionuRL = $(this).data('action');
        var id = $(this).data('id');
        
        $('#edit_modal').load(actionuRL, function() {
            $(this).modal('show');
            $("#leave_status").val(id);
        });
    });

    $(document).on('click', '.expense-edit-button', function () {
        var actionuRL = $(this).data('action');
        var id = $(this).data('id');
        
        $('#edit_modal').load(actionuRL, function() {
            $(this).modal('show');
            $("#approval_status").val(id);
        });
    });

    $(document).on('click', '.decline-edit-button', function () {
        var actionuRL = $(this).data('action');
        var id = $(this).data('id');
        
        $('#edit_modal').load(actionuRL, function() {
            $(this).modal('show');
            $("#approval_status").val(id);
        });
    });


    $('#modal_delete_button').on('click', function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: $("#modal_delete_action").val(), 
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token 
            },
            success: function (response) {
                // Handle success response
                if ($('#collection_centers_table').length > 0) {
                    collection_centers_table.ajax.reload();
                }
                if ($('#contract_types_table').length > 0) {
                    contract_types_table.ajax.reload();
                }
                if ($('#collected_milk_table').length > 0) {
                    collected_milk_table.ajax.reload();
                }
                if ($('#categories_table').length > 0) {
                    categories_table.ajax.reload();
                }
                if ($('#units_table').length > 0) {
                    units_table.ajax.reload();
                }
                if ($('#deductions_table').length > 0) {
                    deductions_table.ajax.reload();
                }

                if ($('#deduction_types_table').length > 0) {
                    deduction_types_table.ajax.reload();
                }
                if ($('#shares_table').length > 0) {
                    shares_table.ajax.reload();
                }
                if ($('#asset_categories_table').length > 0) {
                    asset_categories_table.ajax.reload();
                }
                if ($('#assets_table').length > 0) {
                    assets_table.ajax.reload();
                }
                
                if ($('#leave_types_table').length > 0) {
                    leave_types_table.ajax.reload();
                }
                
                if ($('#employees_group_table').length > 0) {
                    employees_group_table.ajax.reload();
                }

                if ($('#employees_table').length > 0) {
                    employees_table.ajax.reload();
                }

                if ($('#all_employees_table').length > 0) {
                    all_employees_table.ajax.reload();
                }

                if ($('#packages_table').length > 0) {
                    packages_table.ajax.reload();
                }

                if ($('#subscriptions_table').length > 0) {
                    subscriptions_table.ajax.reload();
                }

                if ($('#projects_table').length > 0) {
                    projects_table.ajax.reload();
                }

                if ($('#all_staff_projects_table').length > 0) {
                    all_staff_projects_table.ajax.reload();
                }

                if ($('#leaves_table').length > 0) {
                    leaves_table.ajax.reload();
                }

                if ($('#pending_leaves_table').length > 0) {
                    pending_table.ajax.reload();
                }

                if ($('#all_leaves_table').length > 0) {
                    leaves_table.ajax.reload();
                }

                if ($('#staff_leaves_table').length > 0) {
                    staff_leaves_table.ajax.reload();
                }

                if ($('#clients_table').length > 0) {
                    clients_table.ajax.reload();
                }

                if ($('#expense_types_table').length > 0) {
                    expense_types_table.ajax.reload();
                }

                if ($('#staff_expenses_table').length > 0) {
                    staff_expenses_table.ajax.reload();
                }

                if ($('#all_expenses_table').length > 0) {
                    all_expenses_table.ajax.reload();
                }

                if ($('#trainings_table').length > 0) {
                    trainings_table.ajax.reload();
                }

                if ($('#pending_trainings_table').length > 0) {
                    pending_trainings_table.ajax.reload();
                }

                if ($('#staff_trainings_table').length > 0) {
                    staff_trainings_table.ajax.reload();
                }

                if ($('#roles_table').length > 0) {
                    roles_table.ajax.reload();
                }

                if ($('#agents_table').length > 0) {
                    agents_table.ajax.reload();
                }

                if ($('#agent_payments_table').length > 0) {
                    agent_payments_table.ajax.reload();
                }

                if ($('#templates_table').length > 0) {
                    templates_table.ajax.reload();
                }

                if ($('#staff_templates_table').length > 0) {
                    staff_templates_table.ajax.reload();
                }
                
               
              
                // Close the modal
                $("#delete_modal").modal('hide');
                toastr.success('Data Deleted Successfully','Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(error);
                toastr.error('Something went wrong','Error');
            }
        });
    });


    $('.try-button').on('click', function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).data('action');
        $('.try-button').hide();
        
        $.ajax({
            url: url, 
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': token 
            },
            success: function (response) {             
                toastr.success(response.message, 'Success');
                // Close the modal
                window.location.reload();
            },
            error: function (xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        });
    });


    $('#modal_delete_reload_button').on('click', function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: $("#modal_delete_reload_action").val(), 
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token 
            },
            success: function (response) {
                // Handle success response              
                // Close the modal
                $("#delete_reload_modal").modal('hide');
                window.location.reload();
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(error);
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        });
    });


});

// load contract types table
$(document).ready(function(){
    
        contract_types_table = $('#contract_types_table').DataTable({
            @include('layout.export_buttons')
                
                processing: true,
                serverSide: false,
                ajax: {
                    url : "{{url('departments/list')}}",
                    data: function(d){
                        
                    }
                },
                columnDefs:[{
                        "targets": 1,
                        "orderable": false,
                        "searchable": false
                    }],
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action',className: 'text-right'},
                ],
                createdRow: function( row, data, dataIndex ) {
                }
            });
    });

    // load Salary types table
    $(document).ready(function(){
        salary_types_table = $('#salary_types_table').DataTable({
            @include('layout.export_buttons')
            
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('salaries/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Allowances Data
    $(document).ready(function(){
        allowances_table = $('#allowances_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('allowances/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'value', name: 'value'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Collection Centers Data
    $(document).ready(function(){
        collection_centers_table = $('#collection_centers_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('centers/collection-centers')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'center_name', name: 'center_name'},
                {data: 'farmers', name: 'farmers'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Bank Data
    $(document).ready(function(){
        banks_table = $('#banks_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('cooperative/banks')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'bank_name', name: 'bank_name'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Benefit in Kind Data
    $(document).ready(function(){
        benefits_in_kind_table = $('#benefit_in_kind_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('benefits/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'value', name: 'value'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
        
        leave_types_table = $('#leave_types_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('leave-types/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'type_name', name: 'type_name'},
                {data: 'leave_days', name: 'leave_days'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Statutory Deductions Data
    $(document).ready(function(){
        statutory_table = $('#statutory_deductions_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('deductions/statutory_deductions')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'value', name: 'value'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Non Statutory Deductions Data
    $(document).ready(function(){
        non_statutory_table = $('#non_statutory_deductions_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('deductions/non_statutory_deductions')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'value', name: 'value'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Employee Groups Data
    $(document).ready(function(){
        employees_group_table = $('#employees_group_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('employees/list-groups')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'min_salary', name: 'min_salary'},
                {data: 'max_salary', name: 'max_salary'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Packages Data
    $(document).ready(function(){
        packages_table = $('#packages_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('packages/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'module', name: 'module'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Subscription Data
    $(document).ready(function(){
        subscriptions_table = $('#subscriptions_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('superadmin/subscription-plans')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'tenantName', name: 'tenantName'},
                {data: 'packageName', name: 'packageName'},
                {data: 'type', name: 'type'},
                {data: 'amount_paid', name: 'amount_paid'},
                {data: 'end_date', name: 'end_date'},
                {data: 'created_at', name: 'created_at'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        my_subscriptions_table = $('#my_subscriptions_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('dashboard/subscriptions')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'packageName', name: 'packageName'},
                {data: 'type', name: 'type'},
                {data: 'amount_paid', name: 'amount_paid'},
                {data: 'created_at', name: 'created_at'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

     // load Users Data
     $(document).ready(function(){
        users_table = $('#users_table').DataTable({
            @include('layout.export_buttons')
            
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('superadmin/list/users')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'type', name: 'type'},  
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        roles_table = $('#roles_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('superadmin/list/roles')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'},
                {data: 'name', name: 'name'},
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Clients Data
    $(document).ready(function(){
        clients_table = $('#clients_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('superadmin/list/clients')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-right'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'companyName', name: 'companyName'},
                {data: 'employeeCount', name: 'employeeCount'},
                {data: 'type', name: 'type'}, 
                {data: 'packageName', name: 'packageName'},
                {data: 'expiry_date', name: 'expiry_date'},  
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Projects Data
    $(document).ready(function(){
        projects_table = $('#projects_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('projects/list')}}",
                data: function(d){
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'title', name: 'title'},
                {data: 'start_date', name: 'start_date'},
                {data: 'due_date', name: 'due_date'},
                {data: 'priority', name: 'priority'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'project_team', name: 'project_team'},
                {data: 'progress', name: 'progress'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    //All Staff Projects
    $(document).ready(function(){
        all_staff_projects_table = $('#all_staff_projects_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/all-staff-projects')}}",
                data: function(d){
                    
                }
            }, 
            
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'title', name: 'title'},
                {data: 'start_date', name: 'start_date'},
                {data: 'due_date', name: 'due_date'},
                {data: 'priority', name: 'priority'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'project_team', name: 'project_team'},
                {data: 'progress', name: 'progress'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Projects Data
    $(document).ready(function(){
        employee_projects_table = $('#employee_projects_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/projects')}}",
                data: function(d){
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'title', name: 'title'},
                {data: 'start_date', name: 'start_date'},
                {data: 'due_date', name: 'due_date'},
                {data: 'priority', name: 'priority'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'project_team', name: 'project_team'},
                {data: 'progress', name: 'progress'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Leaves Data
    $(document).ready(function(){
        leaves_table = $('#leaves_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('leaves/list')}}",
                data: function(d){
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'total', name: 'total'},
                {data: 'taken', name: 'taken'},
                {data: 'balance', name: 'balance'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

     // load Pending Leaves Data
     $(document).ready(function(){
         $('#daterange').daterangepicker({
            opens: 'bottom',
            ranges: ranges
        }, function(start, end, label) {
            pending_leaves_table.ajax.reload();
        });
        
        pending_leaves_table = $('#pending_leaves_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('leaves/pendingLeaves')}}",
                data: function(d){
                    // Access the start and end dates from the date range picker
                    var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

                    // Add the dates as parameters to the request
                    d.date_from = startDate;
                    d.date_to = endDate;
                    d.type = $("#leave_type").val();
                    d.applicant = $("#applicant").val();
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'employeeName', name: 'employeeName'},
                {data: 'type', name: 'type'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
        
        $(document).on('change', '#leave_type, #applicant', function () {
            pending_leaves_table.ajax.reload();
        })
    });

    // load All Leaves Data
    $(document).ready(function(){
        $('#daterange').daterangepicker({
            opens: 'bottom',
            ranges: ranges
        }, function(start, end, label) {
            leaves_table.ajax.reload();
        });

        leaves_table = $('#all_leaves_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('leaves/all-leaves')}}",
                data: function(d){
                    // Access the start and end dates from the date range picker
                    var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

                    // Add the dates as parameters to the request
                    d.date_from = startDate;
                    d.date_to = endDate;
                    d.type = $("#leave_type").val();
                    d.status = $("#status").val();
                    d.applicant = $("#applicant").val();
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'employeeName', name: 'employeeName'},
                {data: 'type', name: 'type'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        

        $(document).on('change', '#leave_type, #status, #applicant', function () {
            leaves_table.ajax.reload();
        })
    });

    // load Employee Leaves Data
    $(document).ready(function(){
        $('#daterange').daterangepicker({
            opens: 'bottom',
            ranges: ranges
        }, function(start, end, label) {
            emp_leaves_table.ajax.reload();
        });
        
        emp_leaves_table = $('#emp_leaves_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/leaves')}}",
                data: function(d){
                    
                    // Access the start and end dates from the date range picker
                    var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

                    // Add the dates as parameters to the request
                    d.date_from = startDate;
                    d.date_to = endDate;
                    d.type = $("#leave_type").val();
                    d.status = $("#status").val();
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                // {data: 'employeeName', name: 'employeeName'},
                {data: 'type', name: 'type'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                // {data: 'remaining_days', name: 'remaining_days'},
                {data: 'status', name: 'status'},   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
        
        $(document).on('change', '#leave_type, #status', function () {
            emp_leaves_table.ajax.reload();
        })
    });

    $(document).ready(function(){
        staff_leaves_table = $('#staff_leaves_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/allLeaves')}}",
                data: function(d){
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'employeeName', name: 'employeeName'},
                {data: 'type', name: 'type'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });


    // load Projects Data
    $(document).ready(function(){
        employee_attendance_table = $('#employee_attendance_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('attendance/staffAttendance')}}",
                data: function(d){
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'date', name: 'date'},
                {data: 'punch_in', name: 'punch_in'},
                {data: 'punch_out', name: 'punch_out'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Employees Admin Attendance Data
    $(document).ready(function(){
        subscriptions_table = $('#emp_attendances_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('attendance/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'tenantName', name: 'tenantName'},
                {data: 'packageName', name: 'packageName'},
                {data: 'amount_paid', name: 'amount_paid'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Emails Data
    $(document).ready(function(){
        outbox_table = $('#outbox_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('communications/emails')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'created_at', name: 'created_at'},
                {data: 'email', name: 'email'},
                {data: 'subject', name: 'subject'},
                {data: 'message', name: 'message'},
                // {data: 'status', name: 'status'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Expense Types Data
    $(document).ready(function(){
        expense_types_table = $('#expense_types_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('expenses/expense-types')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Staff Expenses Data
    $(document).ready(function(){
        staff_expenses_table = $('#staff_expenses_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('expenses/staff-expenses')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'expenseName', name: 'expenseName'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'date', name: 'date'},
                {data: 'amount', name: 'amount'},
                {data: 'purpose', name: 'purpose'},
                {data: 'approval_status', name: 'approval_status'},
                {data: 'payment_status', name: 'payment_status'},   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load All Expenses Data
    $(document).ready(function(){
        all_expenses_table = $('#all_expenses_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('expenses/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'expenseName', name: 'expenseName'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'date', name: 'date'},
                {data: 'amount', name: 'amount'},
                {data: 'purpose', name: 'purpose'},
                {data: 'approval_status', name: 'approval_status'},
                {data: 'payment_status', name: 'payment_status'},   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    //All Staff Expenses
    $(document).ready(function(){
        companies_expenses_table = $('#companies_expenses_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('expenses/all-staff-expenses')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'expenseName', name: 'expenseName'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'date', name: 'date'},
                {data: 'amount', name: 'amount'},
                {data: 'purpose', name: 'purpose'},
                {data: 'approval_status', name: 'approval_status'},
                {data: 'payment_status', name: 'payment_status'},   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

      // load Trainings Data
      $(document).ready(function(){
        trainings_table = $('#trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('trainings/list')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'time', name: 'time'},
                {data: 'vendor', name: 'vendor'},
                {data: 'location', name: 'location'},
                {data: 'description', name: 'description'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        pending_trainings_table = $('#pending_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('trainings/list-pending')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'trainingName', name: 'trainingName'},
                {data: 'trainingType', name: 'trainingType'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'created_at', name: 'created_at'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        list_trainings_table = $('#list_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('trainings/list-requests')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'trainingName', name: 'trainingName'},
                {data: 'trainingType', name: 'trainingType'},
                {data: 'employeeName', name: 'employeeName'},
                {data: 'approval_status', name: 'approval_status'},
                {data: 'completion_status', name: 'completion_status'},
                {data: 'certificate', name: 'cerificate'},
                {data: 'created_at', name: 'created_at'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        staff_list_trainings_table = $('#staff_list_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/list-requests')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action'},
                {data: 'trainingName', name: 'trainingName'},
                {data: 'trainingType', name: 'trainingType'},
                {data: 'approval_status', name: 'approval_status'},
                {data: 'completion_status', name: 'completion_status'},
                {data: 'upload', name: 'upload'},
                {data: 'certificate', name: 'cerificate'},
                {data: 'created_at', name: 'created_at'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
        
        staff_invited_trainings_table = $('#staff_invited_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/list-invites')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action'},
                {data: 'trainingName', name: 'trainingName'},
                {data: 'trainingType', name: 'trainingType'},
                {data: 'approval_status', name: 'approval_status'},
                {data: 'completion_status', name: 'completion_status'},
                {data: 'certificate', name: 'cerificate'},
                {data: 'created_at', name: 'created_at'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    //All Staff Trainings
    $(document).ready(function(){
        all_staff_trainings_table = $('#all_staff_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/all-staff-trainings')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'time', name: 'time'},
                {data: 'vendor', name: 'vendor'},
                {data: 'location', name: 'location'},
                {data: 'description', name: 'description'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    // load Staff Trainings Data
    $(document).ready(function(){
        staff_trainings_table = $('#staff_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/trainings')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'time', name: 'time'},
                {data: 'vendor', name: 'vendor'},
                {data: 'location', name: 'location'},
                {data: 'description', name: 'description'},
                {data: 'upload', name: 'upload'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // load Employee Trainings Data
    $(document).ready(function(){
        employee_trainings_table = $('#employee_trainings_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/trainings')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'time', name: 'time'},
                {data: 'vendor', name: 'vendor'},
                {data: 'location', name: 'location'},
                {data: 'description', name: 'description'}
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

        // load Agents Data
    $(document).ready(function(){
        agents_table = $('#agents_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('superadmin/list/agents')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'phone_no', name: 'phone_no'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'total_income', name: 'total_income'},
                {data: 'total_commission', name: 'total_commission'},
                {data: 'total_paid', name: 'total_paid'},
                {data: 'balance', name: 'balance'},
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    $(document).ready(function(){
        agent_payments_table = $('#agent_payments_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                //url : "{{url('superadmin/agent-payments/')}}"  + "/"+response.id,
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'amount', name: 'amount'},
                {data: 'date', name: 'date'},
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    $(document).ready(function(){
        templates_table = $('#templates_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('communications/email-templates')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'template', name: 'template'},
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    $(document).ready(function(){
        staff_templates_table = $('#staff_templates_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/email-templates')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'name', name: 'name'},
                {data: 'template', name: 'template'},
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    // Update Expense Status
    $(document).submit('#update_expense_request',function(e){
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = $("#update_expense_request");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                if ($('#trainings_table').length > 0) {
                    trainings_table.ajax.reload();
                }

                if ($('#pending_trainings_table').length > 0) {
                    pending_trainings_table.ajax.reload();
                }

                if ($('#staff_trainings_table').length > 0) {
                    staff_trainings_table.ajax.reload();
                }
                if ($('#staff_invited_trainings_table').length > 0) {
                    staff_invited_trainings_table.ajax.reload();
                }
                
                if ($('#staff_list_trainings_table').length > 0) {
                    staff_list_trainings_table.ajax.reload();
                }
                if ($('#all_expenses_table').length > 0) {
                    all_expenses_table.ajax.reload();
                }
                $("#edit_modal").modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
                
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            }
            
        });
    });


    function calculateTax(amount) {
        let total_tax = 0;
        let remaining_salary = amount;

        // Tax band 1: $0 tax for first $750
        if (remaining_salary > 402) {
            let band1_amount = Math.min(remaining_salary, 402);
            total_tax += 0; // No tax in this band
            remaining_salary -= band1_amount;
        }

        // Tax band 2: 2% tax on amounts between $751 and $2500
        if (remaining_salary > 0 && remaining_salary > 402) {
            let band2_amount = Math.min(remaining_salary, 512 - 402);
            let tax_rate_band2 = 0.05;
            total_tax += band2_amount * tax_rate_band2;
            remaining_salary -= band2_amount;
        }

        // Tax band 3: 10% tax on amounts between $2501 and $4500
        if (remaining_salary > 0 && remaining_salary > 512) {
            let band3_amount = Math.min(remaining_salary, 642 - 512);
            let tax_rate_band3 = 0.1;
            total_tax += band3_amount * tax_rate_band3;
            remaining_salary -= band3_amount;
        }

        // Tax band 4: 18% tax on amounts between $4501 and $8000
        if (remaining_salary > 0 && remaining_salary > 642) {
            let band4_amount = Math.min(remaining_salary, 3642 - 642);
            let tax_rate_band4 = 0.175;
            total_tax += band4_amount * tax_rate_band4;
            remaining_salary -= band4_amount;
        }

        // Tax band 5: 25% tax on amounts between $8001 and $10000
        if (remaining_salary > 0 && remaining_salary > 3642) {
            let band5_amount = Math.min(remaining_salary, 20037 - 3642);
            let tax_rate_band5 = 0.25;
            total_tax += band5_amount * tax_rate_band5;
            remaining_salary -= band5_amount;
        }

        // Tax band 6: 30% tax on amounts between $8001 and $10000
        if (remaining_salary > 0 && remaining_salary > 20037) {
            let band6_amount = Math.min(remaining_salary, 50000 - 20037);
            let tax_rate_band6 = 0.30;
            total_tax += band6_amount * tax_rate_band6;
            remaining_salary -= band6_amount;
        }

        // Tax band 7: 10% tax on amounts above $10000
        if (remaining_salary > 0) {
            let tax_rate_band7 = 0.35;
            total_tax += remaining_salary * tax_rate_band7;
        }

        // Round the total tax to 2 decimal places
        total_tax = Math.round(total_tax * 100) / 100;

        return total_tax;
    }

    function calculatePayslipTotals(){
            $('.calc_value').each(function() {
                var calcValue = parseFloat($(this).val());
                var calcType = $(this).closest('tr').find('.calc_type').val();
                var basicSalary = parseFloat($("#basic_salary").val());
                var calcTotal = 0;

                if (calcType === 'fixed') {
                calcTotal = calcValue;
                } else if (calcType === 'percentage') {
                calcTotal = (calcValue * basicSalary) / 100;
                }

                // Check if calcTotal is NaN, if so, set it to 0
                if (isNaN(calcTotal)) {
                calcTotal = 0;
                }

                $(this).closest('tr').find('.calc_total').val(calcTotal);


                var total_nonstat = 0;
                $('input[name="nonstatutory_value[]"]').each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_nonstat += value;
                    }
                });

                var total_stat = 0;
                $('input[name="statutory_value[]"]').each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_stat += value;
                    }
                });

                var total_allowance = 0;
                $('input[name="allowance_value[]"]').each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_allowance += value;
                    }
                });

                var total_benefit = 0;
                $('input[name="benefit_value[]"]').each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_benefit += value;
                    }
                });

                $("#total_allowance").html(total_allowance);
                $("#total_emolument").html((basicSalary+total_allowance));

                $("#total_stat").html(total_stat);
                $("#total_gross").html((basicSalary + total_allowance + total_benefit));

                $("#total_nonstat").html(total_nonstat);
                $("#total_taxable").html((basicSalary + total_allowance + total_benefit - total_stat));

                $("#total_benefit").html(total_benefit);

                
                
                var salary = basicSalary + total_allowance + total_benefit - total_stat;
                total_tax = calculateTax(salary) ;

                // Round the total tax to 2 decimal places
                total_tax = Math.round(total_tax * 100) / 100;

                $("#total_tax").html(total_tax);

                $("#income_after").html((salary-total_tax));
                $("#net_pay").html((salary-total_tax-total_nonstat));
            });
        }

  


        function startTimer() {
            var startTime = localStorage.getItem('startTime'); // Retrieve the stored start time

            if (!startTime) {
                // If no start time is stored, set the current time as the start time
                startTime = Date.now();
                localStorage.setItem('startTime', startTime);
            }

            // Update the timer every second
            setInterval(function() {
                var currentTime = Date.now();
                var elapsedTime = currentTime - startTime;

                // Format the elapsed time as hours, minutes, and seconds
                var hours = Math.floor(elapsedTime / (1000 * 60 * 60));
                var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

                // Update the timer element with the formatted time
                document.getElementById('timer').textContent = hours + 'h ' + minutes + 'm ' + seconds + 's';
            }, 1000);
        }

        // Check if the timer should be started
        document.addEventListener('DOMContentLoaded', function() {
            var startTime = localStorage.getItem('startTime');

            if (startTime) {
                // If start time is stored, start the timer
                startTimer();
            }
        });


        // Check if the timer should be started
        document.addEventListener('DOMContentLoaded', function() {
            var startTime = localStorage.getItem('startTime');

            if (startTime) {
                $('#punch_button').html("Punch Out");
                // If start time is stored, start the timer
                startTimer();
            }else{
                $('#punch_button').html('Punch In')
            }
        });

        // Add event listener to the button
        $(document).on('click', '#punch_button', function () {
            var startTime = localStorage.getItem('startTime');

            if (startTime) {
                // If start time is stored, clear it and stop the timer
                localStorage.removeItem('startTime');
                document.getElementById('timer').textContent = '';
            } else {
                // If start time is not stored, start the timer
                startTimer();
            }
        });

    // Function to pad a number with leading zeros
    function padZero(number) {
        return (number < 10 ? "0" : "") + number;
    }

    // Handle the click event
    $("#punch_button").click(function() {
        if (timerInterval) {
            // If the timer is already running, reset it
            resetTimer();
        } else {
            // If the timer is not running, start it
            startTimer();
        }
    });

        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Success');
        @endif
        
        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Error');
        @endif

    // Toastr Initialization
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
   
   
</script>