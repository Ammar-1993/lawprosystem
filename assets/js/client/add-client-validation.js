"use strict";
var checkExistRoute = $("#route-exist-check").val();
var token = $("#token-value").val();
var FormControlsClient = {
    init: function () {
        var btn = $("form :submit");
        $("#add_client").validate({
            debug: false,
            rules: {
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
                    number: true,
                },
                alternate_no: {
                    required: false,
                    minlength: 10,
                    maxlength: 10,
                    number: true,
                },
                reference_mobile: {
                    required: false,
                    minlength: 10,
                    maxlength: 10,
                    number: true,
                },
            },

            // START: Modified messages section
            messages: {
                f_name: validationMessages.f_name,
                m_name: validationMessages.m_name,
                l_name: validationMessages.l_name,
                address: validationMessages.address,
                country: validationMessages.country,
                state: validationMessages.state,
                city_id: validationMessages.city_id,

                email: {
                    // Assuming you add an 'email' key like 'Please enter a valid email.' to your backend.php files
                    // If not, add one: 'email' => 'Please enter a valid email.' in en/backend.php
                    // and 'email' => 'الرجاء إدخال بريد إلكتروني صحيح.' in ar/backend.php
                    email:
                        validationMessages.email?.email ??
                        "Please enter valid email.", // Using optional chaining and nullish coalescing for safety
                },
                mobile: {
                    required: validationMessages.mobile.required,
                    minlength: validationMessages.mobile.minlength,
                    maxlength: validationMessages.mobile.maxlength,
                    number: validationMessages.mobile.number,
                },
                alternate_no: {
                    // Only include messages for rules that are active (e.g., required is false here)
                    minlength: validationMessages.alternate_no.minlength,
                    maxlength: validationMessages.alternate_no.maxlength,
                    number: validationMessages.alternate_no.number,
                },
                reference_mobile: {
                    // Only include messages for rules that are active (e.g., required is false here)
                    minlength: validationMessages.reference_mobile.minlength,
                    maxlength: validationMessages.reference_mobile.maxlength,
                    number: validationMessages.reference_mobile.number,
                },
            },
            // END: Modified messages section

            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass("text-danger");
            },
            submitHandler: function () {
                $("#show_loader").removeClass("fa-save");
                $("#show_loader").addClass("fa-spin fa-spinner");
                $("button[name='btn_add_user']")
                    .attr("disabled", "disabled")
                    .button("refresh");
                return true;
            },
        });
    },
};
jQuery(document).ready(function () {
    FormControlsClient.init();

    //set initial state.
    $("#change_court_chk").on("click", function () {
        if ($(this).is(":checked")) {
            var returnVal = this.value;
            if (returnVal == "Yes") {
                $("#change_court_div").removeClass("hidden");
            }
        } else {
            $("#change_court_div").addClass("hidden");
        }
    });

    $(".two").css("display", "none");

    $("input[type=radio][name=type]").on("change", function () {
        if (this.value == "single") {
            $(".one").css("display", "block");
            $(".two").css("display", "none");
        } else if (this.value == "multiple") {
            $(".two").css("display", "block");
            $(".one").css("display", "none");
        }
    });

    $(".repeater").repeater({
        initEmpty: false,
        defaultValues: {
            "text-input": "foo",
        },
        show: function () {
            $(this).slideDown();
            var id = $(this).find('[type="text"]').attr("id");
            var label = $(this).find("label");
            label.attr("for", id);
            $(this).addClass("fade-in-info").slideDown();
        },
        hide: function (deleteElement) {
            // START: Modified confirmation message
            if (confirm(validationMessages.are_you_sure_you_want_delete)) {
                // END: Modified confirmation message
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false,
    });
});
