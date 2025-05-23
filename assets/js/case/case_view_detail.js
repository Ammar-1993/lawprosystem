"use strict";
var getNextDateModals = $("#getNextDateModals").val();

function nextDateAdd(case_id) {
  // ajax get modal
  $.ajax({
    url: getNextDateModals + "/" + case_id,
    success: function (data) {
      $("#show_modal_next_date").html(data);
      $("#modal-next-date").modal({
        backdrop: false,
        show: true,
      });

      // show bootstrap modal
      $(".modal-title").text("Add Next Date"); // Set Title to Bootstrap modal title
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("Error adding / update data");
    },
  });
}
