"use strict";

var token = $('#token-value').val();
var advo_client_id = $('#advo_client_id').val();
var get_case_important_modal = $('#get_case_important_modal').val();
var get_case_next_modal = $('#get_case_next_modal').val();
var get_case_cort_modal = $('#get_case_cort_modal').val();

var t;
var DatatableRemoteAjaxDemo = function () {


    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        t = $('#clientCaselistDatatable1').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            "ajax": {
                "url": $('#clientCaselistDatatable1').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data":
                    {
                        _token: token,
                        advocate_client_id: advo_client_id
                    }
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "court"},
                {"data": "case"},
                {"data": "next_date"},
                {"data": "status"},
                {"data": "options"}
            ],
            //Set column definition initialisation properties.

            "columnDefs": [
                {
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-2], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-3], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-4], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-5], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-6], //last column
                    "orderable": false, //set not orderable
                }
            ]
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function () {
            lsitDataInTable();


        }
    };
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()
});


function nextDateAdd(case_id) {
    // ajax get modal
    $.ajax({
        url: get_case_next_modal + "/" + case_id,
        success: function (data) {
            $('#show_modal_next_date').html(data);
            $('#modal-next-date').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Next Date'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}

function change_case_important(case_id) {
    // ajax get modal
    $.ajax({
        url: get_case_important_modal + '/' + case_id,
        success: function (data) {
            $('#show_modal').html(data);
            $('#modal-case-priority').modal('show'); // show bootstrap modal
            $('.modal-title').text('Change Case Important'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}

function transfer_case(case_id) {

    // ajax get modal
    $.ajax({
        url: get_case_cort_modal + "/" + case_id,
        success: function (data) {
            $('#show_modal_transfer').html(data);
            $('#modal-change-court').modal('show'); // show bootstrap modal
            $('.modal-title').text('Case Transfer'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}
