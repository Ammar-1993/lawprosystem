"use strict";
var checkExistRoute = $('#common_check_exist').val();
var token = $('#token-value').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#roleForm").validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                slug: {
                    required: true,
                    remote: {
                        async: false,
                        url: checkExistRoute,
                        type: "post",
                        data: {
                            _token: function () {
                                return token
                            },
                            form_field: function () {
                                return $("#slug").val();
                            },
                            id: function ()
                            {
                                return $("#id").val();
                            },
                            db_field: function () {
                                return 'slug';
                            },
                            table: function () {
                                return 'roles';
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
                slug:{
                    required:"Role name is required",
                    remote: "Role name already exits."
                }
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                // var formData = $("#categoryform");
                $("#cl").removeClass('ik ik-check-circle').addClass('fa fa-spinner fa-spin');
                var formData = new FormData($("#roleForm")[0]);
                var url = $("#roleForm").attr('action');

                $.ajax({
                    url:url,
                    type:'POST',
                    processData: false,
                    contentType: false,
                    data:formData,
                    success:function(data) {
                        $("#addtag").modal('hide');
                        $("#roleDataTable").dataTable().api().ajax.reload();
                        message.fire({
                            type: 'success',
                            title: 'Success' ,
                            text: data.message,
                        });
                    },
                    error:function(xhr, status, error) {
                        /* Act on the event */
                        if( xhr.status === 422 ) {

                            var errors = xhr.responseJSON.errors;
                            errorsHtml = '<div class="alert alert-danger"><ul>';
                            $.each( errors , function( key, value ) {
                                console.log( value[0] );
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></di>';
                            $( '#form-errors' ).html( errorsHtml );

                        }
                        $("#cl").removeClass('fa fa-spinner fa-spin').addClass('ik ik-check-circle');
                        message.fire({
                            type: 'error',
                            title: 'Error' ,
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

});
