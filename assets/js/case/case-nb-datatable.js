"use strict";

var get_case_important_modal = $('#get_case_important_modal').val();
var get_case_next_modal = $('#get_case_next_modal').val();
var get_case_cort_modal = $('#get_case_cort_modal').val();
var case_url = $('#case_url').val();
var token = $('#token-value').val();
var t;
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#case_list').DataTable({
            "processing": true,
            "serverSide": true,
            // "responsive":true,
            "order": [[0, "desc"]],
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            "ajax": {
                "url": case_url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    case_listing: 'NB',
                    date_from: $('#date_from').val(),
                    date_to: $('#date_to').val(),
                }
            },
            AutoWidth: false,
            "columns": [
                {"data": "id", width: '3%'},
                {"data": "name", width: '20%'},
                {"data": "court", width: '35%'},
                {"data": "case", width: '20%'},
                {"data": "next_date", width: '10%'},
                {"data": "status", width: '9%'},
                {"data": "options", width: '3%'}
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

            $('#date_from,#date_to').on('change', function () {
                if ($('#date_from').val() == "" && $('#date_to').val() == "") {
                    $("#search").attr("disabled", "disabled");
                } else {
                    $('#search').removeAttr('disabled');
                }
            });


            $(".dateFrom").datepicker({
                format: $('#date_format_datepiker').val(),
                autoclose: true,
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('.dateTo').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('.dateTo').datepicker('setStartDate', null);
            });

            $(".dateTo").datepicker({
                format: $('#date_format_datepiker').val(),
                autoclose: true,
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('.dateFrom').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('.dateFrom').datepicker('setEndDate', null);
            });


            $("#search").click(function () {
                t.destroy();
                DatatableRemoteAjaxDemo.init()
            });

            $("#clear").click(function () {
                $('#date_from').val('');
                $('#date_to').val('');
                t.destroy();
                DatatableRemoteAjaxDemo.init()
                $("#search").attr("disabled", "disabled");
            });

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



