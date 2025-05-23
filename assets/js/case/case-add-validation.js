"use strict";
// تأكد من أن كائن الترجمة caseValidationData مُتاح
// يمكنك إضافة commonJsLang إذا كنت ستستخدمه لرسائل SweetAlert العامة أو غيرها
if (typeof caseValidationData === "undefined") {
  console.error(
    "caseValidationData object not found. Ensure it is injected in Blade before this script."
  );
  // تعيين كائن فارغ كإجراء احتياطي لمنع توقف السكريبت
  var caseValidationData = {
    validation: {},
    placeholders: {},
    labels: {},
    confirm: {},
    misc: { loading: "Loading..." },
  };
}
// var commonJsLang = commonJsLang || { error_title: 'Error', success_title: 'Success' };

var select2Case = $("#select2Case").val(); // هذا المتغير يبدو أنه غير مستخدم في الكود الذي قدمته
var date_format_datepiker = $("#date_format_datepiker").val();
var getCaseSubTypes = $("#getCaseSubType").val();
var getCourts = $("#getCourt").val();

var FormControlsClient = {
  // يمكنك إعادة تسميته إلى FormControlsCase للوضوح

  init: function () {
    var btn = $("form :submit");
    $("#add_case").validate({
      rules: {
        client_name: "required",
        // party_name and party_advocate are in repeater, validation might be handled by data-attributes
        // but we'll keep them here if jquery-validation is intended to pick them up by name
        // 'parties_detail[0][party_name]': "required", // Example if repeater names fields like this
        case_no: "required",
        case_type: "required",
        case_status: "required",
        act: "required",
        court_type: "required",
        next_date: "required",
        court_no: "required",
        court_name: "required", // Name of select field for court
        judge_type: "required", // Name of select field for judge
        filing_number: "required",
        filing_date: "required",
        registration_number: "required",
        registration_date: "required",
      },
      messages: {
        // استخدام الترجمات من caseValidationData.validation
        client_name:
          caseValidationData.validation.client_name ||
          "Please enter client name.",
        // party_name: caseValidationData.validation.party_name || "Please enter name.", (see note about repeater)
        // party_advocate: caseValidationData.validation.party_advocate || "Please enter advocate name.", (see note about repeater)
        case_no:
          caseValidationData.validation.case_no || "Please enter case number.",
        case_type:
          caseValidationData.validation.case_type || "Please select case type.",
        case_status:
          caseValidationData.validation.case_status ||
          "Please select stage of case.",
        act: caseValidationData.validation.act || "Please enter act.",
        court_type:
          caseValidationData.validation.court_type ||
          "Please select court type.",
        next_date:
          caseValidationData.validation.next_date ||
          "Please select first hearing date.",
        court_no:
          caseValidationData.validation.court_no ||
          "Please enter court number.",
        court_name:
          caseValidationData.validation.court_name || "Please select court.", // Updated to reflect select
        judge_type:
          caseValidationData.validation.judge_type || "Please select judge.", // Updated to reflect select
        filing_number:
          caseValidationData.validation.filing_number ||
          "Please enter filing number.",
        filing_date:
          caseValidationData.validation.filing_date ||
          "Please select filing date.",
        registration_number:
          caseValidationData.validation.registration_number ||
          "Please enter registration number.",
        registration_date:
          caseValidationData.validation.registration_date ||
          "Please select registration date.",
      },
      errorPlacement: function (error, element) {
        if (element.is("select") && element.parent().hasClass("form-group")) {
          // Or specific class for select2 parent
          error.appendTo(element.parent()).addClass("text-danger");
        } else if (element.closest(".input-group").length) {
          // For date pickers or inputs with addons
          error
            .appendTo(element.closest(".input-group").parent())
            .addClass("text-danger");
        } else {
          error.appendTo(element.parent()).addClass("text-danger");
        }
      },
      submitHandler: function (form) {
        // تم تغيير المتغير إلى form
        $("#show_loader").removeClass("fa-save").addClass("fa-spin fa-spinner");
        // استخدام $(form) للإشارة إلى النموذج الحالي
        $(form).find("button[type='submit']").attr("disabled", "disabled"); //.button('refresh') is jQuery UI, not always present
        form.submit(); // إرسال النموذج الأصلي
      },
    });
  },
};

jQuery(document).ready(function () {
  if (typeof FormControlsClient !== "undefined") {
    // Or FormControlsCase
    FormControlsClient.init(); // Or FormControlsCase.init();
  }

  // Datepicker initialization (no changes needed for translation here unless date format needs localization)
  $(".datetimepickerfilingdate").datepicker({
    format: date_format_datepiker,
    autoclose: true, // "close" is not a valid boolean value, use true
    todayHighlight: true,
    clearBtn: true,
  });
  // ... (بقية Datepickers بنفس الطريقة) ...
  $(".datetimepickerregdate").datepicker({
    format: date_format_datepiker,
    autoclose: true,
    todayHighlight: true,
    clearBtn: true,
  });

  $(".datetimepickernextdate").datepicker({
    format: date_format_datepiker,
    autoclose: true,
    todayHighlight: true,
    clearBtn: true,
  });

  // Dynamic labels for repeater items
  $("input[type=radio][name=position]").on("change", function () {
    if (this.value == "Respondent") {
      $(".position_name").html(
        caseValidationData.labels.petitioner_name || "Petitioner Name"
      );
      $(".position_advo").html(
        caseValidationData.labels.petitioner_advocate || "Petitioner Advocate"
      );
    } else if (this.value == "Petitioner") {
      $(".position_name").html(
        caseValidationData.labels.respondent_name || "Respondent Name"
      );
      $(".position_advo").html(
        caseValidationData.labels.respondent_advocate || "Respondent Advocate"
      );
    }
  });
  // Initial state for dynamic labels
  if (
    $("input[name=position]:checked").val() === "Petitioner" ||
    !$("input[name=position]:checked").length
  ) {
    $(".position_name").html(
      caseValidationData.labels.respondent_name || "Respondent Name"
    );
    $(".position_advo").html(
      caseValidationData.labels.respondent_advocate || "Respondent Advocate"
    );
  } else {
    $(".position_name").html(
      caseValidationData.labels.petitioner_name || "Petitioner Name"
    );
    $(".position_advo").html(
      caseValidationData.labels.petitioner_advocate || "Petitioner Advocate"
    );
  }

  // Select2 initializations with translated placeholders
  $("#assigned_to").select2({
    allowClear: true,
    placeholder: caseValidationData.placeholders.select_users || "Select Users",
    multiple: true,
  });
  $("#case_type").select2({
    allowClear: true,
    placeholder:
      caseValidationData.placeholders.select_case_type || "Select Case Type",
  });
  $("#case_sub_type").select2({
    allowClear: true,
    placeholder:
      caseValidationData.placeholders.select_case_sub_type ||
      "Select Case Sub Type",
  });
  $("#case_status").select2({
    allowClear: true,
    placeholder:
      caseValidationData.placeholders.select_stage_of_case ||
      "Select Stage of Case",
  });
  $("#court_type").select2({
    allowClear: true,
    placeholder:
      caseValidationData.placeholders.select_court_type || "Select Court Type",
  });
  $("#court_name").select2({
    // This is the select for Court
    allowClear: true,
    placeholder: caseValidationData.placeholders.select_court || "Select Court",
  });
  $("#judge_type").select2({
    // This is the select for Judge (Judge Name in Blade)
    allowClear: true,
    placeholder:
      caseValidationData.placeholders.select_judge_type || "Select Judge Name", // Updated to match common naming
  });
  $("#client_name").select2({
    allowClear: true,
    placeholder:
      caseValidationData.placeholders.select_client_name ||
      "Select Client Name",
  });

  // Repeater initialization
  $(".repeater").repeater({
    initEmpty: false,
    defaultValues: {
      // 'text-input': 'foo' // This seems like a placeholder, adjust if needed
    },
    show: function () {
      $(this).slideDown();
      // تحديث النصوص الديناميكية عند إضافة عنصر جديد
      var test = $("input[name=position]:checked").val();
      if (test == "Respondent") {
        $(this)
          .find(".position_name")
          .html(caseValidationData.labels.petitioner_name || "Petitioner Name");
        $(this)
          .find(".position_advo")
          .html(
            caseValidationData.labels.petitioner_advocate ||
              "Petitioner Advocate"
          );
      } else if (test == "Petitioner") {
        $(this)
          .find(".position_name")
          .html(caseValidationData.labels.respondent_name || "Respondent Name");
        $(this)
          .find(".position_advo")
          .html(
            caseValidationData.labels.respondent_advocate ||
              "Respondent Advocate"
          );
      }
      // إعادة تهيئة Select2 للعناصر الجديدة إذا كانت موجودة داخل Repeater (إذا لزم الأمر)
    },
    hide: function (deleteElement) {
      if (
        confirm(
          caseValidationData.confirm.delete_element ||
            "Are you sure you want to delete this element?"
        )
      ) {
        $(this).slideUp(deleteElement);
      }
    },
    ready: function (setIndexes) {
      // setIndexes();
    },
    isFirstItemUndeletable: true,
  });

  // Trigger change on radio once to set initial repeater labels correctly if there's a checked radio
  // $('input[type=radio][name=position]:checked').trigger('change');
  // The initial setup for labels is now done above more reliably.
});

// AJAX Functions (getCaseSubType, getCourt)
function getCaseSubType(id) {
  var loadingText =
    typeof caseValidationData !== "undefined" &&
    caseValidationData.misc &&
    caseValidationData.misc.loading
      ? caseValidationData.misc.loading
      : "Loading...";
  if (id == "") {
    $("#case_sub_type").html("").trigger("change"); // Trigger change for select2
  } else {
    $("#case_sub_type")
      .html("")
      .prepend($("<option></option>").attr("value", "").html(loadingText))
      .trigger("change");
  }
  if (id != "") {
    // AJAX setup and call as in your original code
    $.ajax({
      url: getCaseSubTypes, // Ensure this variable is correctly defined and holds the URL
      method: "POST",
      data: { id: id, _token: $('meta[name="csrf-token"]').attr("content") }, // Add CSRF token
      success: function (result) {
        $("#case_sub_type").html(result).trigger("change"); // Update and trigger change for select2
      },
    });
  }
}

function getCourt(id) {
  var loadingText =
    typeof caseValidationData !== "undefined" &&
    caseValidationData.misc &&
    caseValidationData.misc.loading
      ? caseValidationData.misc.loading
      : "Loading...";
  if (id == "") {
    $("#court_name").html("").trigger("change");
  } else {
    $("#court_name")
      .html("")
      .prepend($("<option></option>").attr("value", "").html(loadingText))
      .trigger("change");
  }
  if (id != "") {
    // AJAX setup and call as in your original code
    $.ajax({
      url: getCourts, // Ensure this variable is correctly defined and holds the URL
      method: "POST",
      data: { id: id, _token: $('meta[name="csrf-token"]').attr("content") }, // Add CSRF token
      success: function (result) {
        $("#court_name").html(result).trigger("change"); // Update and trigger change for select2
      },
    });
  }
}
