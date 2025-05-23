"use strict";
var token = $('#token-value').val();
var common_check_exist = $('#common_check_exist').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#mail_setup").validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_smtp']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();
    $("#timezone").select2();

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than 5Mb');

    $("#favicon").checkImageSize({
        minWidth: 16,
        minHeight: 16,
        maxWidth: 16,
        maxHeight: 16,
        showError: true,
        ignoreError: false

    });


    $("#logo").checkImageSize({
        minWidth: 230,
        minHeight: 46,
        maxWidth: 230,
        maxHeight: 46,
        showError: true,
        ignoreError: false

    });

});
