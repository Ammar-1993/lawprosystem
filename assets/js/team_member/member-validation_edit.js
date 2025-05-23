// Ensure translation objects are available
if (typeof memberValidationMessages === 'undefined' || typeof commonJsLang === 'undefined') {
    console.error('Validation message objects (member or common) not found. Check Blade injection.');
} else {

    var check_user_email_exits = $('#check_user_email_exits').val();
    var token = $('#token-value').val();
    var FormControlsClient = {

        init: function () {
            var btn = $("form :submit");

            // Custom password check method
            $.validator.addMethod("pwcheck", function (value) {
                // Only validate if the password field has a value (optional on edit)
                if (value === '') return true;
                return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value);
            });

            // IMPORTANT: Make sure "#add_user" is the correct ID for your EDIT form.
            // It might be something like "#edit_user_form" or similar in your edit Blade file.
            $("#add_user").validate({
                rules: {
                    f_name: "required",
                    l_name: "required",
                    email: {
                        required: true,
                        email: true,
                        remote: { // Keep remote validation config for checking existing email, now including ID
                            url: check_user_email_exits,
                            type: "post",
                            data: {
                                _token: function () { return token; },
                                email: function () { return $("#email").val(); },
                                id: function () { return $("#id").val(); } // ID is needed for edit check
                            }
                        }
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    address: "required",
                    zip_code: {
                        required: true,
                        minlength: 6,
                        maxlength: 6,
                        number: true
                    },
                    password: {
                        // Password might be optional on edit, required only if chk_pass is checked?
                        // Adjust rules based on your form logic (e.g., using depends)
                        // For now, assuming it follows same rules if entered
                        required: false, // Typically optional on edit unless changing
                        pwcheck: true,
                        minlength: 8,
                    },
                    cnm_password: { // Changed key to match rules
                         // Required only if password is being entered
                        required: function(element) {
                            return $("#password").val().length > 0;
                        },
                        equalTo: "#password",
                    },
                    country: "required",
                    state: "required",
                    city_id: "required",
                    role: "required"
                },
                // START: Use injected messages
                messages: {
                    // username: { ... } // If username field exists
                    f_name: memberValidationMessages.f_name,
                    l_name: memberValidationMessages.l_name,
                    email: {
                        required: memberValidationMessages.email.required,
                        email: memberValidationMessages.email.email,
                        remote: memberValidationMessages.email.remote
                    },
                    mobile: {
                        required: memberValidationMessages.mobile.required,
                        minlength: memberValidationMessages.mobile.minlength,
                        maxlength: memberValidationMessages.mobile.maxlength,
                        number: memberValidationMessages.mobile.number,
                    },
                    address: memberValidationMessages.address,
                    zip_code: {
                        required: memberValidationMessages.zip_code.required,
                        minlength: memberValidationMessages.zip_code.minlength,
                        maxlength: memberValidationMessages.zip_code.maxlength,
                        number: memberValidationMessages.zip_code.number,
                    },
                    password: {
                        // required: memberValidationMessages.password.required, // Only if always required on edit
                        pwcheck: memberValidationMessages.password.pwcheck,
                        minlength: memberValidationMessages.password.minlength
                    },
                    cnm_password: { // Changed key to match rules
                        required: memberValidationMessages.cnm_password.required, // Required if password entered
                        equalTo: memberValidationMessages.cnm_password.equalTo
                    },
                    country: memberValidationMessages.country,
                    state: memberValidationMessages.state,
                    city_id: memberValidationMessages.city_id,
                    role: memberValidationMessages.role,
                },
                // END: Use injected messages
                errorPlacement: function (error, element) {
                     if (element.hasClass('select2-hidden-accessible')) {
                         error.insertAfter(element.next('.select2-container')).addClass('text-danger');
                     } else {
                         error.appendTo(element.parent()).addClass('text-danger');
                     }
                },
                submitHandler: function (form) { // Pass form to handler
                    $('#show_loader').removeClass('fa-save');
                    $('#show_loader').addClass('fa-spin fa-spinner');
                    $(form).find("button[type='submit']").attr("disabled", "disabled");
                    form.submit();
                }
            });
        }

    };

    jQuery(document).ready(function () {
        FormControlsClient.init();

        // --- Keep your checkbox logic for showing/hiding password fields ---
        $(".chk").hide(); // Assuming password fields start hidden on edit
        // Check initial state if needed based on server-side logic
        $('#chk_pass').on('click', function (ev) {
             var isChecked = $(this).is(':checked');
             $(".chk").toggle(isChecked);
             // Make password required only if checkbox is checked
             $("#password").rules("add", { required: isChecked });
             $("#cnm_password").rules("add", { required: isChecked }); // Also make confirm required
             // Re-validate if needed
             // $(this).closest('form').validate().element("#password");
             // $(this).closest('form').validate().element("#cnm_password");
        });

        // Initialize Select2 with translated placeholder
        $("#role").select2({
            allowClear: true,
            placeholder: memberValidationMessages.select_role_placeholder,
        });

        // --- Croppie and Image Upload Logic (same as before) ---
        var $uploadCrop = $('#upload-demo').croppie({ /* ... croppie options ... */ });
        $("#upload-demo").hide(); // May start hidden or show existing image initially

        $('#upload').on('change', function () {
            var reader = new FileReader();
            // Use translated messages
            if (this.files[0].size > 5242880) { // 5 mb
                message.fire({
                    type: 'error',
                    title: commonJsLang.error_title,
                    text: memberValidationMessages.file_size_error,
                });
                 $(this).val('');
                 $("#upload-demo").hide();
                return false;
            }
            reader.onload = function (e) {
                var result = e.target.result;
                var arrTarget = result.split(';');
                var tipo = arrTarget[0];
                 if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
                    $("#upload-demo").show();
                    // ... (show/hide cropper UI elements) ...
                    $uploadCrop.croppie('bind', { url: e.target.result })
                        .then(function(){ console.log('jQuery bind complete'); });
                } else {
                     message.fire({
                        type: 'error',
                        title: commonJsLang.error_title,
                        text: memberValidationMessages.file_type_error,
                     });
                     $('#upload').val('');
                     $("#upload-demo").hide();
                }
            }
            reader.readAsDataURL(this.files[0]);
        });

        // Keep other image upload event listeners
        $('#cancel_img').on('click', function () { /* ... */ });
        $('#upload-result').on('click', function (ev) { /* ... */ });

        // Ensure Select2 is initialized (duplicate initialization removed)
        // $("#role").select2({ ... }); // Already initialized above

    });

} // End of safety check