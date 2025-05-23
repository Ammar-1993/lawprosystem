"use strict";
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#form_case_imp").validate({
            rules: {
                priority: "required"
            },
            messages: {
                priority: "Please select priority."
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function () {
                $('#btn_loader').removeClass('hide');
                $("button[name='update_case_important']").attr("disabled", "disabled");
                //Add data using ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('admin/changeCasePriority')}}",
                    method: "POST",
                    data: {
                        priority: $('#priority').val(),
                        id: $('#id').val()
                    },
                    success: function (result) {
                        console.log(result);
                        if (result.errors) {
                            $('#btn_loader').addClass('hide');
                            $("button[name='update_case_important']").removeAttr("disabled", "disabled").button('refresh');
                            $('.alert-danger').html('');

                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').css("display", "block");
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('#modal-case-priority').modal('hide');
                            //location.reload();
                            // success_massage('Case proirity changed successfully.');

                            message.fire({
                                type: 'success',
                                title: 'Success',
                                text: "Case proirity changed successfully.",
                            });

                            // window.location.reload();

                            t.ajax.reload();


                        }
                        //location.reload();
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

