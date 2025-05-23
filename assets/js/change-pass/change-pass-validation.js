"use strict";

// Check if translations are available from Blade injection
if (typeof changePasswordValidationMessages !== "undefined") {
    // Keep original variables if potentially used elsewhere, though not needed for messages
    var checkExistRoute = $("#common_check_exist").val();
    var token = $("#token-value").val();

    var FormControlsClient = {
        // Consider renaming FormControlsClient if this is not client-related
        init: function () {
            var btn = $("form :submit");

            // Keep custom validation method - logic doesn't need translation
            $.validator.addMethod("pwcheck", function (value) {
                // Password complexity regex - Must contain A-Z, a-z, 0-9, special char, min 6 chars (rule uses 8)
                return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(
                    value
                );
            });

            $("#change_password").validate({
                debug: false, // Set to true for debugging if needed
                ignore: ":hidden", // Standard ignore pattern
                rules: {
                    old: "required",
                    new: {
                        required: true,
                        pwcheck: true, // Use the custom rule
                        minlength: 8,
                    },
                    confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#new", // Ensure the ID #new matches the new password input ID
                    },
                },
                // Use injected messages via changePasswordValidationMessages object
                messages: {
                    old: changePasswordValidationMessages.validation_old_required,
                    new: {
                        required:
                            changePasswordValidationMessages.validation_new_required,
                        pwcheck:
                            changePasswordValidationMessages.validation_new_pwcheck, // Message for the custom rule
                        minlength:
                            changePasswordValidationMessages.validation_new_minlength,
                    },
                    confirm: {
                        required:
                            changePasswordValidationMessages.validation_confirm_required,
                        minlength:
                            changePasswordValidationMessages.validation_confirm_minlength,
                        equalTo:
                            changePasswordValidationMessages.validation_confirm_equalTo,
                    },
                },
                errorPlacement: function (error, element) {
                    // Place the error message after the parent element (usually a div container)
                    error.appendTo(element.parent()).addClass("text-danger");
                },
                submitHandler: function (form) {
                    // Pass form argument
                    $("#show_loader").removeClass("fa-save"); // Assuming #show_loader exists for feedback
                    $("#show_loader").addClass("fa-spin fa-spinner");

                    // Ensure the button name 'btn_add_change' is correct for this form
                    // Using $(form).find() is safer if multiple forms exist
                    $(form)
                        .find("button[name='btn_add_change']")
                        .attr("disabled", "disabled")
                        .button("refresh"); // Assumes jQuery UI Button widget if used

                    // Explicitly submit the form
                    form.submit();
                },
            });
        },
    }; // End FormControlsClient

    jQuery(document).ready(function () {
        FormControlsClient.init();
    });
} else {
    // Fallback or error if translations weren't injected
    console.error(
        "Change password validation messages object (changePasswordValidationMessages) not found. Check Blade injection."
    );
    // Validation might still work but show default jQuery Validate English messages or fail based on setup
}
