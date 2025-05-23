$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

// --- call-model: No changes needed ---
$(document).on("click", ".call-model", function (e) {
  e.preventDefault();
  var el = $(this);
  var url = el.data("url");
  var target = el.data("target-modal");

  $.ajax({
    type: "GET",
    url: url,
  })
    .always(function () {
      $("#load-modal").html(" ");
    })
    .done(function (res) {
      $("#load-modal").html(res.html);
      $(target).modal("toggle");
    });
});

// --- change-status: Update Swal messages ---
$(document).on("click", ".change-status", function (e) {
  var el = $(this);
  var url = el.data("url");
  var id = el.val();
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id: id,
      status: el.prop("checked"),
    },
  })
    .always(function (respons) {})
    .done(function (respons) {
      // Use injected translations
      message.fire({
        type: "success",
        title: commonJsLang.success_title, // Updated
        text: respons.message, // Message from server (should be translated server-side)
      });
    })
    .fail(function (respons) {
      // Use injected translations
      message.fire({
        type: "error",
        title: commonJsLang.error_title, // Updated
        text: commonJsLang.generic_error, // Updated default text
      });
    });
});

// --- delete-confrim: Update Swal messages ---
$(document).on("click", ".delete-confrim", function (e) {
  e.preventDefault();
  var el = $(this);
  var url = el.attr("href");
  var id = el.data("id");
  var refresh = el.closest("table");
  console.log(refresh);

  // Use injected translations
  message
    .fire({
      title: commonJsLang.confirm_title, // Updated
      text: commonJsLang.confirm_text, // Updated
      type: "warning",
      customClass: {
        confirmButton: "btn btn-success shadow-sm mr-2",
        cancelButton: "btn btn-danger shadow-sm",
      },
      buttonsStyling: false,
      showCancelButton: true,
      confirmButtonText: commonJsLang.confirm_button, // Updated
      cancelButtonText: commonJsLang.cancel_button, // Updated
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: id,
            _method: "DELETE",
          },
        })
          .always(function (respons) {
            // Consider checking if DataTable exists before reloading
            if ($.fn.DataTable.isDataTable(refresh)) {
              $(refresh).DataTable().ajax.reload();
            }
          })
          .done(function (respons) {
            // Use injected translations
            message.fire({
              type: "success",
              title: commonJsLang.success_title, // Updated
              text: respons.message, // Message from server (should be translated server-side)
            });
          })
          .fail(function (respons) {
            var res = respons.responseJSON;
            // Use injected translations for default
            var msg = commonJsLang.generic_error; // Updated default text
            // Server can override with its own (potentially translated) error
            if (res && res.errormessage) {
              msg = res.errormessage;
            }
            // Use injected translations
            message.fire({
              type: "error",
              title: commonJsLang.error_title, // Updated
              text: msg,
            });
          });
      }
    });
});

// --- DataTable Defaults: Update pagination text ---
if (jQuery().dataTable) {
  $.extend(true, $.fn.dataTable.defaults, {
    // Use oLanguage for defaults, or 'language' if preferred (check DT version compatibility)
    oLanguage: {
      sEmptyTable: commonJsLang.dt_empty_table,
      sInfo: commonJsLang.dt_info, // Translates "Showing _START_ to _END_ of _TOTAL_ entries"
      sInfoEmpty: commonJsLang.dt_info_empty,
      sInfoFiltered: commonJsLang.dt_info_filtered,
      sInfoPostFix: "",
      sInfoThousands: ",", // Adjust if needed for Arabic numerals/grouping
      sLengthMenu: commonJsLang.dt_length_menu, // Translates "Show _MENU_ entries"
      sLoadingRecords: commonJsLang.dt_loading_records,
      sProcessing: commonJsLang.dt_processing,
      sSearch: commonJsLang.dt_search, // Translates "Search:" label
      // sSearchPlaceholder: commonJsLang.dt_search_placeholder || "", // Add placeholder if defined
      sZeroRecords: commonJsLang.dt_zero_records,
      oPaginate: {
        sFirst: commonJsLang.dt_first,
        sLast: commonJsLang.dt_last,
        sNext:
          '<span class="pagination-default"></span><span class="pagination-fa">' +
          commonJsLang.dt_next +
          "</span>", // Keep existing style
        sPrevious:
          '<span class="pagination-default"></span><span class="pagination-fa">' +
          commonJsLang.dt_previous +
          "</span>", // Keep existing style
      },
      oAria: {
        sSortAscending: commonJsLang.dt_sort_ascending,
        sSortDescending: commonJsLang.dt_sort_descending,
      },
    },
  });
}

// --- Swal Mixins: No changes needed ---
const toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 8000,
});

const message = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success shadow-sm mr-2",
    cancelButton: "btn btn-danger shadow-sm",
  },
  buttonsStyling: false,
});

// --- jQuery Validate Methods: Update messages ---
if (jQuery().validate) {
  // Use injected translations
  jQuery.validator.addMethod(
    "phonenumber",
    function (value, element) {
      var a = value;
      var filter =
        /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
      if (filter.test(a)) {
        return true;
      } else {
        return false;
      }
    },
    commonJsLang.validation_phone
  ); // Updated

  // Use injected translations
  $.validator.addMethod(
    "filesize",
    function (value, element, param) {
      if (element.files.length) {
        return this.optional(element) || element.files[0].size <= param;
      }
      return true;
    },
    commonJsLang.validation_filesize
  ); // Updated

  // Use injected translations
  $.validator.addMethod(
    "ckdata",
    function (value, element, param) {
      // Ensure CKEDITOR is loaded and instance exists
      if (
        typeof CKEDITOR !== "undefined" &&
        CKEDITOR.instances[$(element).attr("id")]
      ) {
        var editor = CKEDITOR.instances[$(element).attr("id")];
        if (editor.getData().length <= 0) {
          return false;
        } else {
          return true;
        }
      }
      return true; // Or handle error if CKEDITOR not ready
    },
    commonJsLang.validation_required
  ); // Updated
}

// --- ajaxindicatorstart: Use translated text when calling ---
// No change needed here, but pass translated text when calling the function
// e.g., ajaxindicatorstart(commonJsLang.loading);
function ajaxindicatorstart(text) {
  if (jQuery("body").find("#resultLoading").attr("id") != "resultLoading") {
    jQuery("body").append(
      '<div id="resultLoading" style="display:none"><div><img src=""><div>' +
        text +
        '</div></div><div class="bg"></div></div>'
    );
  }
  // CSS remains the same
  jQuery("#resultLoading").css({
    /* ... */
  });
  jQuery("#resultLoading .bg").css({
    /* ... */
  });
  jQuery("#resultLoading>div:first").css({
    /* ... */
  });

  jQuery("#resultLoading .bg").height("100%");
  jQuery("#resultLoading").fadeIn(300);
  jQuery("body").css("cursor", "wait");
}

// --- ajaxindicatorstop: No changes needed ---
function ajaxindicatorstop() {
  jQuery("#resultLoading .bg").height("100%");
  jQuery("#resultLoading").fadeOut(300);
  jQuery("body").css("cursor", "default");
}
