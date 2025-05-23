"use strict";
// Ensure validationMessages variable is available (defined in Blade)
// var checkExistRoute = $('#route-exist-check').val(); // Keep if needed for other logic
// var token = $('#token-value').val(); // Keep if needed for other logic

var FormControlsClient = {

    init: function () {
        // Ensure the validationMessages object exists before initializing validation
        if (typeof validationMessages === 'undefined') {
            console.error('Validation messages object not found. Check Blade injection.');
            return; // Stop initialization if translations are missing
        }

        var btn = $("form :submit");
        $("#edit_client_form").validate({ // Ensure this ID matches your edit form
            debug: false,
            rules: {
                // Rules remain the same
                f_name: "required",
                m_name: "required",
                l_name: "required",
                address: "required",
                country: "required",
                state: "required",
                city_id: "required",
                email: {
                    email: true,
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                alternate_no: {
                    required: false,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                reference_mobile: {
                    required: false,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                }
            },
            // START: Modified messages section to use validationMessages object
            messages: {
                f_name: validationMessages.f_name,
                m_name: validationMessages.m_name,
                l_name: validationMessages.l_name,
                address: validationMessages.address,
                country: validationMessages.country,
                state: validationMessages.state,
                city_id: validationMessages.city_id,

                email: {
                    // Assuming 'email.email' key exists in your backend.php like discussed before
                    email: validationMessages.email?.email ?? "Please enter valid email.",
                },
                mobile: {
                    required: validationMessages.mobile.required,
                    minlength: validationMessages.mobile.minlength,
                    maxlength: validationMessages.mobile.maxlength,
                    number: validationMessages.mobile.number,
                },
                alternate_no: {
                    required: validationMessages.alternate_no.required, // Make sure key exists if needed
                    minlength: validationMessages.alternate_no.minlength,
                    maxlength: validationMessages.alternate_no.maxlength,
                    number: validationMessages.alternate_no.number,
                },
                reference_mobile: {
                    required: validationMessages.reference_mobile.required, // Make sure key exists if needed
                    minlength: validationMessages.reference_mobile.minlength,
                    maxlength: validationMessages.reference_mobile.maxlength,
                    number: validationMessages.reference_mobile.number,
                }
            },
            // END: Modified messages section
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (form) { // Pass form to handler
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                // Disable submit button more reliably
                $(form).find("button[type='submit']").attr("disabled", "disabled");
                form.submit(); // Submit the form
                // return true; // Not strictly needed when using form.submit()
            }
        });
    }

};

jQuery(document).ready(function () {
    FormControlsClient.init();

    // --- Repeater logic ---
    // Keep your existing repeater show/hide logic for #change_court_div and radio buttons

    $("#change_court_chk").on("click", function () {
       if ($(this).is(":checked")) {
           var returnVal = this.value;
           if (returnVal == 'Yes') {
               $('#change_court_div').removeClass('hidden');
           }
       } else {
           $('#change_court_div').addClass('hidden');
       }
    });

    $('input[type=radio][name=type]').on("change", function () {
        if (this.value == 'single') {
           $('.one').css('display', 'block');
           $('.two').css('display', 'none');
        }
        else if (this.value == 'multiple') {
           $('.two').css('display', 'block');
           $('.one').css('display', 'none');
        }
    });


    $('.repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo'
        },
        show: function () {
            $(this).slideDown();
            // Simplified ID handling for example; adjust if needed
            // var id = $(this).find('[type="text"]').attr('id');
            // var label = $(this).find('label');
            // label.attr('for',id);
            // $(this).addClass('fade-in-info').slideDown();
        },
        hide: function (deleteElement) {
            // START: Use translated confirmation message
            // Ensure validationMessages is available here too
            if (typeof validationMessages !== 'undefined' && confirm(validationMessages.are_you_sure_you_want_delete)) {
                 $(this).slideUp(deleteElement);
            } else if (typeof validationMessages === 'undefined' && confirm('Are you sure you want to delete this element?')) {
                 // Fallback if translations not loaded (should not happen ideally)
                 console.error('Validation messages not found for repeater confirmation.');
                 $(this).slideUp(deleteElement);
            }
            // END: Use translated confirmation message
        },
        isFirstItemUndeletable: false
    });
});