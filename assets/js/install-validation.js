"use strict";

var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $('#installerForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                app_name: "required",
                app_url: "required",
                db_host: "required",
                db_port: "required",
                db_database: "required",
                db_username: "required",
                //db_password: "required",
                user_name: "required",
                user_email: {
                    required: true,
                    email: true
                },
                user_pwd: {
                    required: true,
                    minlength : 6,
                    maxlength: 8,
                },
                user_cpwd: {
                    required: true,
                    minlength : 6,
                    maxlength: 8,
                    equalTo : "#user_pwd"
                }

            },
            messages: {
                app_name: "Please enter app name.",
                app_url: "Please enter app url.",
                db_host: "Please enter database host.",
                db_port: "Please enter database port.",
                db_database: "Please enter database name.",
                db_username: "Please enter database user name.",
                // db_password: "Please enter database user password.",
                user_name: "Please enter name.",
                user_email: {
                    required: "Please enter login email.",
                    email: "Please enter valid email.",
                },
                user_pwd: {
                    required: "Please enter login password.",
                    minlength: "Password must be 6 digit.",
                    maxlength: "Password must be 8 digit.",
                },
                user_cpwd: {
                    required: "Please enter confirm password.",
                    minlength: "Confirm password must be 6 digit.",
                    maxlength: "Confirm password must be 8 digit.",
                }

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                $('#show_loader').text('installing...');
                $("button[name='btn_add_client']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();
});
