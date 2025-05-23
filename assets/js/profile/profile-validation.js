"use strict";
var checkExistRoute = $("#route-exist-check").val();
var token = $("#token-value").val();
var FormControlsProfile = {
  init: function () {
    var btn = $("form :submit");
    $("#add_user").validate({
      // ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
      rules: {
        f_name: "required",
        l_name: "required",
        mobile: {
          required: true,
          minlength: 10,
          maxlength: 10,
          number: true,
        },
        address: "required",
        zip_code: {
          required: true,
          minlength: 6,
          maxlength: 6,
          number: true,
        },
        country: "required",
        registration_no: "required",
        associated_name: "required",
        state: "required",
        city_id: "required",
        email: {
          required: true,
          email: true,
          remote: {
            url: checkExistRoute,
            type: "post",
            data: {
              _token: function () {
                return token;
              },
              email: function () {
                return $("#email").val();
              },
              id: function () {
                return $("#id").val();
              },
            },
          },
        },
      },

      // استخدام رسائل التحقق المترجمة التي تم تمريرها
      messages: {
        f_name:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.f_name
            ? profileValidationMessages.f_name
            : "Please enter first name.", // رسالة إنجليزية احتياطية
        l_name:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.l_name
            ? profileValidationMessages.l_name
            : "Please enter last name.",
        mobile: {
          required:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.mobile &&
            profileValidationMessages.mobile.required
              ? profileValidationMessages.mobile.required
              : "Please enter mobile.",
          minlength:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.mobile &&
            profileValidationMessages.mobile.minlength
              ? profileValidationMessages.mobile.minlength
              : "Mobile must be 10 digits.",
          maxlength:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.mobile &&
            profileValidationMessages.mobile.maxlength
              ? profileValidationMessages.mobile.maxlength
              : "Mobile must be 10 digits.",
          number:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.mobile &&
            profileValidationMessages.mobile.number
              ? profileValidationMessages.mobile.number
              : "Please enter a valid 10-digit mobile number (0-9).",
        },
        address:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.address
            ? profileValidationMessages.address
            : "Please enter address.",
        zip_code: {
          required:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.zip_code &&
            profileValidationMessages.zip_code.required
              ? profileValidationMessages.zip_code.required
              : "Please enter zip code.",
          minlength:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.zip_code &&
            profileValidationMessages.zip_code.minlength
              ? profileValidationMessages.zip_code.minlength
              : "Zip code must be 6 digits.",
          maxlength:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.zip_code &&
            profileValidationMessages.zip_code.maxlength
              ? profileValidationMessages.zip_code.maxlength
              : "Zip code must be 6 digits.",
          number:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.zip_code &&
            profileValidationMessages.zip_code.number
              ? profileValidationMessages.zip_code.number
              : "Please enter a valid 6-digit zip code (0-9).",
        },
        country:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.country
            ? profileValidationMessages.country
            : "Please select country.",
        registration_no:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.registration_no
            ? profileValidationMessages.registration_no
            : "Please enter registration number.",
        associated_name:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.associated_name
            ? profileValidationMessages.associated_name
            : "Please enter associated name.",
        state:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.state
            ? profileValidationMessages.state
            : "Please select state.",
        city_id:
          typeof profileValidationMessages !== "undefined" &&
          profileValidationMessages.city_id
            ? profileValidationMessages.city_id
            : "Please select city.",
        email: {
          required:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.email &&
            profileValidationMessages.email.required
              ? profileValidationMessages.email.required
              : "Please enter email.",
          email:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.email &&
            profileValidationMessages.email.email
              ? profileValidationMessages.email.email
              : "Please enter valid email.",
          remote:
            typeof profileValidationMessages !== "undefined" &&
            profileValidationMessages.email &&
            profileValidationMessages.email.remote
              ? profileValidationMessages.email.remote
              : "Email is already exits.",
        },
      },

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
  FormControlsProfile.init();
});
