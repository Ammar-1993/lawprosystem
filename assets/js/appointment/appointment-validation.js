"use strict";
var checkExistRoute = $("#common_check_exist").val();
var token = $("#token-value").val();
var date_format_datepiker = $("#date_format_datepiker").val();
var getMobilenos = $("#getMobileno").val();

var FormControlsClient = {
  init: function () {
    var btn = $("form :submit");
  },
};

jQuery(document).ready(function () {
  FormControlsClient.init();

  $(".exists").addClass("hidden");
  $("#date").datepicker({
    format: date_format_datepiker,
    autoclose: "close",
    startDate: "0d",
    todayHighlight: true,
  });

  $("#time").datetimepicker({
    format: "hh:mm A",
  });

  $("#exists_client").select2({
    placeholder: "Select clien",
  });

  $("input[type=radio][name=type]").on("change", function () {
    if (this.value == "exists") {
      $(".exists").removeClass("hidden");
      $(".new").addClass("hidden");

      $("#exists_client").val("").select2({
        placeholder: "Select client",
      });
    } else if (this.value == "new") {
      // alert("new");
      $(".exists").addClass("hidden");
      $(".new").removeClass("hidden");
      $("#mobile").val("").prop("disabled", false);
    }
  });
});

function getMobileno(id) {
  if (id != "") {
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    $.ajax({
      url: getMobilenos,
      method: "POST",
      data: { id: id },
      success: function (data) {
        $("#mobile").val(data.mobile).prop("readonly", true);
      },
    });
  }
}
