// Ensure translation objects are available at the very top
if (typeof memberValidationMessages === 'undefined' || typeof commonJsLang === 'undefined') {
    console.error('Translation objects (memberValidationMessages or commonJsLang) not found. Ensure they are injected in Blade before this script.');
    // Fallback to empty objects to prevent further errors if script continues
    var memberValidationMessages = memberValidationMessages || {};
    var commonJsLang = commonJsLang || { error_title: 'Error', success_title: 'Success' }; // Basic fallback for titles
}

var check_user_email_exits = $('#check_user_email_exits').val();
var token = $('#token-value').val();

// It's good practice to rename FormControlsClient if this is for Team Members, e.g., FormControlsTeamMember
var FormControlsTeamMember = { // Renamed for clarity

    init: function () {
        var btn = $("form :submit");

        // Custom password check method (from your provided code)
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value);
        });

        $("#add_user").validate({
            rules: {
                f_name: "required",
                l_name: "required",
                email: {
                    required: true,
                    email: true,
                    remote: { // Remote configuration from your code
                        url: check_user_email_exits,
                        type: "post",
                        data: {
                            _token: function () { return token; },
                            email: function () { return $("#email").val(); },
                            id: function () { return $("#id").val(); } // Assuming an ID field for edit, or remove if create-only
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
                    required: true,
                    pwcheck: true, // Custom rule from your code
                    minlength: 8,
                },
                cnm_password: { // Field name from your blade and lang file
                    required: true,
                    equalTo: "#password",
                },
                country: "required",
                state: "required",
                city_id: "required",
                role: "required"
            },
            messages: {
                // username is commented out as it's not in the blade file
                // username: {
                //     required: memberValidationMessages.username && memberValidationMessages.username.required ? memberValidationMessages.username.required : "Please enter username.",
                //     remote: memberValidationMessages.username && memberValidationMessages.username.remote ? memberValidationMessages.username.remote : "Username already exists."
                // },
                f_name: memberValidationMessages.f_name ? memberValidationMessages.f_name : "Please enter first name.",
                l_name: memberValidationMessages.l_name ? memberValidationMessages.l_name : "Please enter last name.",
                email: {
                    required: memberValidationMessages.email && memberValidationMessages.email.required ? memberValidationMessages.email.required : "Please enter email.",
                    email: memberValidationMessages.email && memberValidationMessages.email.email ? memberValidationMessages.email.email : "Please enter valid email.",
                    remote: memberValidationMessages.email && memberValidationMessages.email.remote ? memberValidationMessages.email.remote : "Email already exists."
                },
                mobile: {
                    required: memberValidationMessages.mobile && memberValidationMessages.mobile.required ? memberValidationMessages.mobile.required : "Please enter mobile.",
                    minlength: memberValidationMessages.mobile && memberValidationMessages.mobile.minlength ? memberValidationMessages.mobile.minlength : "Mobile must be 10 digits.",
                    maxlength: memberValidationMessages.mobile && memberValidationMessages.mobile.maxlength ? memberValidationMessages.mobile.maxlength : "Mobile must be 10 digits.",
                    number: memberValidationMessages.mobile && memberValidationMessages.mobile.number ? memberValidationMessages.mobile.number : "Please enter digits 0-9.",
                },
                address: memberValidationMessages.address ? memberValidationMessages.address : "Please enter address.",
                zip_code: {
                    required: memberValidationMessages.zip_code && memberValidationMessages.zip_code.required ? memberValidationMessages.zip_code.required : "Please enter zip code.",
                    minlength: memberValidationMessages.zip_code && memberValidationMessages.zip_code.minlength ? memberValidationMessages.zip_code.minlength : "Zip code must be 6 digits.",
                    maxlength: memberValidationMessages.zip_code && memberValidationMessages.zip_code.maxlength ? memberValidationMessages.zip_code.maxlength : "Zip code must be 6 digits.",
                    number: memberValidationMessages.zip_code && memberValidationMessages.zip_code.number ? memberValidationMessages.zip_code.number : "Please enter digits 0-9.",
                },
                password: {
                    required: memberValidationMessages.password && memberValidationMessages.password.required ? memberValidationMessages.password.required : "Please enter password.",
                    pwcheck: memberValidationMessages.password && memberValidationMessages.password.pwcheck ? memberValidationMessages.password.pwcheck : "Password must meet complexity requirements.",
                    minlength: memberValidationMessages.password && memberValidationMessages.password.minlength ? memberValidationMessages.password.minlength : "Please enter at least 8 characters."
                },
                cnm_password: {
                    required: memberValidationMessages.cnm_password && memberValidationMessages.cnm_password.required ? memberValidationMessages.cnm_password.required : "Please enter confirm password.",
                    equalTo: memberValidationMessages.cnm_password && memberValidationMessages.cnm_password.equalTo ? memberValidationMessages.cnm_password.equalTo : "Please enter the same password."
                },
                country: memberValidationMessages.country ? memberValidationMessages.country : "Please select country.",
                state: memberValidationMessages.state ? memberValidationMessages.state : "Please select state.",
                city_id: memberValidationMessages.city_id ? memberValidationMessages.city_id : "Please select city.",
                role: memberValidationMessages.role ? memberValidationMessages.role : "Please select role."
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('select2-hidden-accessible')) { // For Select2
                    error.insertAfter(element.next('.select2-container')).addClass('text-danger');
                } else {
                    error.appendTo(element.parent()).addClass('text-danger');
                }
            },
            submitHandler: function (form) {
                $('#show_loader').removeClass('fa-save').addClass('fa-spin fa-spinner');
                $(form).find("button[type='submit']").attr("disabled", "disabled");
                form.submit(); // Native form submission
            }
        });
    }
};

jQuery(document).ready(function () {
    if (typeof FormControlsTeamMember !== 'undefined') { // Check if the main object is defined
        FormControlsTeamMember.init();
    }


    // Initialize Select2 with translated placeholder, ensure #role exists
    if ($("#role").length && typeof memberValidationMessages !== 'undefined' && memberValidationMessages.select_role_placeholder) {
        $("#role").select2({
            allowClear: true,
            placeholder: memberValidationMessages.select_role_placeholder,
        });
    }

    // --- Croppie and Image Upload Logic (from your code) ---
    var $uploadCrop = $('#upload-demo'); // Initialize if element exists
    if ($uploadCrop.length) {
        $uploadCrop.croppie({
            enableExif: true,
            viewport: {
                width: 150,
                height: 150,
                type: 'circle' // or 'square'
            },
            boundary: {
                width: 200,
                height: 200
            }
        });
        $("#upload-demo").hide(); // Initially hide cropper
    }


    $('#upload').on('change', function () {
        if (!this.files || !this.files[0]) {
            return;
        }
        var reader = new FileReader();
        var file = this.files[0];

        // File size validation
        if (file.size > 5242880) { // 5 MB
            message.fire({
                type: 'error',
                title: commonJsLang.error_title ? commonJsLang.error_title : 'Error',
                text: memberValidationMessages.file_size_error ? memberValidationMessages.file_size_error : 'File size should not be more than 5MB',
            });
            $(this).val(''); // Clear the invalid file input
            $("#upload-demo").hide();
            return false;
        }

        reader.onload = function (e) {
            var result = e.target.result;
            var arrTarget = result.split(';');
            var fileType = arrTarget[0];

            if (fileType == 'data:image/jpeg' || fileType == 'data:image/png') {
                $("#upload-demo").show();
                // Assuming other elements to show/hide for cropper UI
                $('#demo_profile').hide(); // Hide default profile image

                if ($uploadCrop.length) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    });
                }
            } else {
                message.fire({
                    type: 'error',
                    title: commonJsLang.error_title ? commonJsLang.error_title : 'Error',
                    text: memberValidationMessages.file_type_error ? memberValidationMessages.file_type_error : 'Accept only .jpg .png image',
                });
                $(this).val(''); // Clear the invalid file input (though 'this' inside reader.onload refers to reader)
                $('#upload').val(''); // More reliable way to clear file input
                $("#upload-demo").hide();
            }
        }.bind(this); // Bind 'this' from the event handler to reader.onload
        reader.readAsDataURL(file);
    });

    // Event listener for the main save/submit button of the form
    $('#add_user').on('submit', function() {
        if ($('#upload').get(0).files.length > 0 && $("#upload-demo").is(":visible") && $uploadCrop.length) {
            return $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport',
                format: 'png' // Or 'jpeg'
            }).then(function (resp) {
                $('#imagebase64').val(resp);
                // The form will be submitted by the submitHandler of jQuery Validate
            });
        }
        // If no image is selected or cropper not active, proceed with normal form submission
        // jQuery Validate's submitHandler will take care of actual submission
    });


    $('#cancel_img').on('click', function () {
        $("#upload-demo").hide();
        $('#upload').val(''); // Clear file input
        $('#demo_profile').show(); // Show default profile image
        $('#imagebase64').val(''); // Clear any previous cropped image data
    });

});