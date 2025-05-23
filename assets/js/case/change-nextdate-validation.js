"use strict";
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_next_date").validate({
            rules: {
                case_status: "required",
                next_date: {
                    required: '#is_nb:unchecked'
                },
                decision_date: "required",
                nature_disposal: "required",

            },
            messages: {
                case_status: "Please select case status.",
                next_date: {
                    required: "Please select next date."
                },
                decision_date: "Please select decision date.",
                nature_disposal: "Please enter nature of disposal.",
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },

            submitHandler: function () {
                // Serialize the form data.

                var decision = $('#decision_date').val();

                var formData = $("#add_next_date").serialize();
                $('#btn_loader').removeClass('hide');
                $("button[name='case_next_date_btn']").attr("disabled", "disabled");
                //Add data using ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                $.ajax({
                    url: "{{ url('admin/case-next-date')}}",
                    method: "POST",
                    data: formData,
                    success: function (result) {

                        if (result.errors) {
                            $('#btn_loader').addClass('hide');
                            $("button[name='case_next_date_btn']").removeAttr("disabled", "disabled").button('refresh');
                            $('.alert-danger').html('');

                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').css("display", "block");
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        } else {

                            $('.alert-danger').hide();
                            $('#modal-next-date').modal('hide');

                            $("#next_hear").load(" #next_hear");
                            if (decision != '') {
                                message.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: "Case disposed / closed successfully.",
                                });
                                // alert("Case disposed / closed successfully.");
                                // success_massage('Case disposed / closed successfully.');
                            } else {
                                message.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: "Case next date added successfully.",
                                });


                            }

                            location.reload();
                            if (typeof table === "undefined") {
                                location.reload();
                            } else {
                                t.ajax.reload();
                            }


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
    $('.case_next_date').datepicker({
        format: '{{$date_format_datepiker}}',
        footer: true,
        todayHighlight: true,
        modal: true,
        autoclose: true,
        startDate: "{{date($date_format_laravel,strtotime($case->next_date. ' +1 day'))}}"
    });
    $('.datetimepickerdecisiondate').datepicker({
        format: '{{$date_format_datepiker}}',
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
        startDate: "{{date($date_format_laravel,strtotime($case->next_date. ' +1 day'))}}"
    });
    var selected_option = $('#case_status option:selected').attr('myvalue');
    if (selected_option == 'Disposed' || selected_option == 'Closed') {
        $('#hide_nb').hide('slow');
    } else {
        $('#hide_nb').show('slow');
    }
    $('#case_status').on('change', function () {

        var option = $('#case_status option:selected').attr('myvalue');


        if (option == 'Disposed' || option == 'Closed') {


            $('#hide_nb').hide('slow');
            $('#show_nextDate_div').hide('slow');
            $('#hide_decisiondate').show('slow');

        } else {
            $('#hide_nb').show('slow');
            if ($('#is_nb').is(':checked')) {

            } else {
                $('#show_nextDate_div').show('slow');
            }

            $('#hide_decisiondate').hide('slow');

        }
    });
});

function nbCheck() {
    if ($('#is_nb').is(":checked"))
        $("#show_nextDate_div").slideUp();
    else
        $("#show_nextDate_div").slideDown();
}