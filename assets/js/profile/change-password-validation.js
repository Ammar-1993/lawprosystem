"use strict";
var FormControlsChangePass = {

    init: function () {
        var btn = $("form :submit");
        $("#change_password").validate({
            rules: {
                old: "required",
                new: {
                    required: true,
                    pwcheck: true,
                    minlength: 8
                },
                confirm: {
                    required: true,
                    minlength: 8,
                    equalTo: "#new"
                }
            },
            messages: {
                old: "Please enter old password.",
                new: {
                    required: "Please enter new password.",
                    pwcheck: 'Password must be minimum 8 characters.password must contain at least 1 lowercase, 1 Uppercase, 1 numeric and 1 special character.',
                    minlength: "Please enter atleast 8 digit."
                },
                confirm: {
                    required: "Please enter confirm password.",
                    minlength: "password must be at least 8 characters long.",
                    equalTo: "Confirm password does not match to password."
                },
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_user']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsChangePass.init();

});
