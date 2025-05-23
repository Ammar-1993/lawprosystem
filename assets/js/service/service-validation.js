"use strict";
var checkExistRoute = $("#common_check_exist").val();
var token = $("#token-value").val();
var FormControlsClient = {
  init: function () {
    var btn = $("form :submit");
    $("#tagForm").validate({
      debug: false,
      ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
      rules: {
        name: {
          required: true,
          remote: {
            async: false,
            url: checkExistRoute,
            type: "post",
            data: {
              _token: function () {
                return token;
              },
              form_field: function () {
                return $("#name").val();
              },
              id: function () {
                return $("#id").val();
              },
              db_field: function () {
                return "name";
              },
              table: function () {
                return "services";
              },
              condition_form_field: function () {
                return "";
              },
              condition_db_field: function () {
                return "";
              },
            },
          },
        },
        amount: {
          required: true,
          number: true,
        },
      },
      messages: {
        name: {
          required:
            typeof serviceValidationMessages !== "undefined" &&
            serviceValidationMessages.name &&
            serviceValidationMessages.name.required
              ? serviceValidationMessages.name.required
              : "Name is required",
          remote:
            typeof serviceValidationMessages !== "undefined" &&
            serviceValidationMessages.name &&
            serviceValidationMessages.name.remote
              ? serviceValidationMessages.name.remote
              : "Name already exists.", // تم التصحيح إلى exists
        },
        amount: {
          required:
            typeof serviceValidationMessages !== "undefined" &&
            serviceValidationMessages.amount &&
            serviceValidationMessages.amount.required
              ? serviceValidationMessages.amount.required
              : "Amount is required",
          number:
            typeof serviceValidationMessages !== "undefined" &&
            serviceValidationMessages.amount &&
            serviceValidationMessages.amount.number
              ? serviceValidationMessages.amount.number
              : "Amount must be a number.", // استخدام رسالة القاعدة number
        },
      },
      errorPlacement: function (error, element) {
        error.appendTo(element.parent()).addClass("text-danger");
      },
      submitHandler: function (e) {
        // var formData = $("#categoryform");
        $("#cl")
          .removeClass("ik ik-check-circle")
          .addClass("fa fa-spinner fa-spin");
        var formData = new FormData($("#tagForm")[0]);
        var url = $("#tagForm").attr("action");

        $.ajax({
          url: url,
          type: "POST",
          processData: false,
          contentType: false,
          data: formData,
          success: function (data) {
            $("#addtag").modal("hide");
            $("#serviceDataTable").dataTable().api().ajax.reload();
            message.fire({
              type: "success",
              title: "Success",
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
                errorsHtml += "<li>" + value[0] + "</li>"; //showing only the first error.
              });
              errorsHtml += "</ul></di>";
              $("#form-errors").html(errorsHtml);
            }
            $("#cl")
              .removeClass("fa fa-spinner fa-spin")
              .addClass("ik ik-check-circle");
            message.fire({
              type: "error",
              title: "Error",
              text: "something went wrong please try again !",
            });
          },
        });
      },
    });
  },
};
jQuery(document).ready(function () {
  FormControlsClient.init();
});
