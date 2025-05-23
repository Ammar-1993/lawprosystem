"use strict";
var token = $('#token-value').val();
var common_check_exist = $('#common_check_exist').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#tagForm").validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                court_name: {
                    required: true,
                    remote: {
                        async: false,
                        url: common_check_exist,
                        type: "post",
                        data: {
                            _token: function () {
                                return token
                            },
                            form_field: function () {
                                return $("#court_name").val();
                            },
                            id: function () {
                                return $("#id").val();
                            },
                            db_field: function () {
                                return 'court_type_name';
                            },
                            table: function () {
                                return 'court_types';
                            },
                            condition_form_field: function () {
                                return '';
                            },
                            condition_db_field: function () {
                                return '';
                            }
                        }
                    }
                }
            },
            messages: {
                court_name: {
                    required: "Court Type is required",
                    remote: "Court type already exits."
                },

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {

                $("#cl").removeClass('ik ik-check-circle').addClass('fa fa-spinner fa-spin');
                var formData = new FormData($("#tagForm")[0]);
                var url = $("#tagForm").attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (data) {
                        $("#addtag").modal('hide');
                        $("#tagDataTable").dataTable().api().ajax.reload();
                        message.fire({
                            type: 'success',
                            title: 'Success',
                            text: data.message,
                        });
                    },
                    error: function (xhr, status, error) {
                        /* Act on the event */
                        if (xhr.status === 422) {

                            var errors = xhr.responseJSON.errors;
                            errorsHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function (key, value) {
                                console.log(value[0]);
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></di>';
                            $('#form-errors').html(errorsHtml);

                        }
                        $("#cl").removeClass('fa fa-spinner fa-spin').addClass('ik ik-check-circle');
                        message.fire({
                            type: 'error',
                            title: 'Error',
                            text: 'something went wrong please try again !',
                        })
                    },
                });
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();
    $(".case_type").select2({
        allowClear: true,
        placeholder: 'Position'
    });
});
