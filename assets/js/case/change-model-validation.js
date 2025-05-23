"use strict";

var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        var url = $("#case_transfer").attr('action');
        $("#case_transfer").validate({
            rules: {
                court_number: "required",
                judge_type: "required",
                transfer_date: "required"
            },
            messages: {
                court_number: "Please enter court number.",
                judge_type: "Please select judge type.",
                transfer_date: "Please select transfer date."
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },

            submitHandler: function () {
                // Serialize the form data.
                var formData = $("#case_transfer").serialize();
                $('#btn_loader').removeClass('hide');
                $("button[name='case_transfer_btn']").attr("disabled", "disabled");
                //Add data using ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    success: function (result) {
                        if (result.errors) {
                            $('#btn_loader').addClass('hide');
                            $("button[name='case_transfer_btn']").removeAttr("disabled", "disabled").button('refresh');
                            $('.alert-danger').html('');

                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').css("display", "block");
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('#modal-change-court').modal('hide');
                            // location.reload();
                            // success_massage('Case transfer between court successfully.');

                            message.fire({
                                type: 'success',
                                title: 'Success',
                                text: "Case transfer between court successfully.",
                            });

                            t.ajax.reload();
                        }
                    }
                });
            }
        });
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();
    $('.select2').select2();
    $('.transfer_date').datepicker({
        format: '{{$date_format_datepiker}}',
        todayHighlight: true,
        footer: true,
        modal: true,
        autoclose: true
    });
});

