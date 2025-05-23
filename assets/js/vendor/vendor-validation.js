"use strict";
var checkExistRoute = $('#route-exist-check').val();
var token = $('#token-value').val();
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
            messages: {
                f_name: "Please enter first name.777",
                m_name: "Please enter middle name.",
                l_name: "Please enter last name.",
                address: "Please enter address.",
                country: "Please select country.",
                state: "Please select state.",
                city_id: "Please select city.",

                email: {
                    email: "Please enter valid email.",
                },
                mobile: {
                    required: "Please enter mobile.",
                    minlength: "Mobile must be 10 digit.",
                    maxlength: "Mobile must be 10 digit.",
                    number: "please enter digit 0-9.",
                },
                alternate_no: {
                    required: "Please enter alternate no.",
                    minlength: "Mobile must be 10 digit.",
                    maxlength: "Mobile must be 10 digit.",
                    number: "please enter digit 0-9.",
                },
                reference_mobile: {
                    required: "Please enter Reference mobile no.",
                    minlength: "Mobile must be 10 digit.",
                    maxlength: "Mobile must be 10 digit.",
                    number: "Please enter digit 0-9.",
                }

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
    FormControlsClient.init();

    //set initial state.
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

    $('.two').css('display', 'none');

    $('input[type=radio][name=type]').on("change", function () {

        if (this.value == 'single') {
            $('.one').css('display', 'block');
            $('.two').css('display', 'none');
        } else if (this.value == 'multiple') {
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
            var id = $(this).find('[type="text"]').attr('id');
            var label = $(this).find('label');
            label.attr('for', id);
            $(this).addClass('fade-in-info').slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    })
});
