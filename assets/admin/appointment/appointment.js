// Validation for #add_appointment form

// Ensure the translation object is available
if (typeof appointmentValidationMessages !== 'undefined') {

    $('#add_appointment').validate({
        debug: false,
        //ignore: '.select2-search__field,:hidden:not("textarea,.files,select")', // Uncomment if needed
        rules: {
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            date: "required",
            time: "required",
            new_client: "required", // Assuming this is conditionally required based on UI logic
            exists_client: "required", // Assuming this is conditionally required based on UI logic
        },
        // START: Use injected messages
        messages: {
            mobile: {
                required: appointmentValidationMessages.mobile.required,
                minlength: appointmentValidationMessages.mobile.minlength,
                maxlength: appointmentValidationMessages.mobile.maxlength,
                number: appointmentValidationMessages.mobile.number,
            },
            date: appointmentValidationMessages.date,
            time: appointmentValidationMessages.time,
            new_client: appointmentValidationMessages.new_client,
            exists_client: appointmentValidationMessages.exists_client
        },
        // END: Use injected messages
        errorPlacement: function (error, element) {
            error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function (form) { // Pass form to handler
            $('#show_loader').removeClass('fa-save');
            $('#show_loader').addClass('fa-spin fa-spinner');
            // Disable submit button more reliably
            $(form).find("button[name='btn_add_appointment']").attr("disabled", "disabled");
            form.submit(); // Submit the form
        }
    });

} else {
    console.error('Appointment validation messages object not found. Check Blade injection.');
}