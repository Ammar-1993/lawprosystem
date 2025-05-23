"use strict";

var token = $('#token-value').val();
var caserunning = $('#case-running').val();
var appointment = $('#appointment').val();
var ajaxCalander = $('#ajaxCalander').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var dashboard_appointment_list = $('#dashboard_appointment_list').val();
var getNextDateModald = $('#getNextDateModal').val();
var getChangeCourtModald = $('#getChangeCourtModal').val();
var getCaseImportantModald = $('#getCaseImportantModal').val();
var getCourtd = $('#getCourt').val();
var downloadCaseBoardd = $('#downloadCaseBoard').val();
var printCaseBoardd = $('#printCaseBoard').val();

var t;
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#appointment_list').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            "ajax": {
                "url": dashboard_appointment_list,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    appoint_date: $('#appoint_range').val()

                }
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                // { "data": "mobile" },
                {"data": "date"},
                {"data": "time"},
                // { "data": "options" },
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
            ], language: {
                paginate: {
                    next: '<i class="fa fa-angle-right">',
                    previous: '<i class="fa fa-angle-left">'
                }
            },


        })
    }

    //== Public Functions
    return {
        // public functions
        init: function () {
            lsitDataInTable();

            $('.datecase').datepicker({
                format: date_format_datepiker,
                autoclose: "close"
            });

            $('#appoint_range').datepicker({
                format: date_format_datepiker,
                autoclose: "close"
            });

            $('#calendar_dashbors_case').fullCalendar({
                eventLimit: true,
                views: {
                    timeGrid: {
                        eventLimit: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                    }
                },
                // put your options and callbacks here
                timezone: 'local',
                left: 'Calendar',
                center: '',
                right: 'today prev,next',
                eventClick: function (calEvent, jsEvent, view) {
                    var id = calEvent.id;

                    if (calEvent.refer == "case") {
                        window.location.href = caserunning + "/" + id;
                    } else {
                        window.location.href = appointment + "/" + id + "/edit";
                    }

                },
                events: function (start, end, timezone, callback) {
                    //ajaxindicatorstart('Please wait a moment..Fetching  detail');
                    var current = $('#calendar_dashbors_case').fullCalendar('getDate');
                    // alert(current);
                    var new_url = ajaxCalander;

                    $.ajax({
                        url: new_url,
                        dataType: 'json',
                        type: 'GET',
                        data: {
                            start: current.format('M'),
                            end: current.format('YYYY')
                        },
                        success: function (response) {
                            callback(response);
                            //ajaxindicatorstop();
                        }
                    })
                }

            });


            $('#appoint_range').on('change', function () {
                t.destroy();
                DatatableRemoteAjaxDemo.init()
            });
            // $("#search").click(function () {
            //     t.destroy();
            //     DatatableRemoteAjaxDemo.init()
            // });
            //
            // $("#clear").click(function () {
            //     $('#date_from').val('');
            //     $('#date_to').val('');
            //     t.destroy();
            //     DatatableRemoteAjaxDemo.init()
            //     $("#search").attr("disabled", "disabled");
            // });


        }
    };
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()
    $('#client_case').on('change',function () {
        $('#case_board_form').submit();
    });

});

function nextDateAdd(case_id) {
    // ajax get modal
    $.ajax({
        url: getNextDateModald + "/" + case_id,
        success: function (data) {
            // ajaxindicatorstop();
            $('#show_modal_next_date').html(data);
            $('#modal-next-date').modal({
                backdrop: false,
                show: true,
            }); // show bootstrap modal
            $('.modal-title').text('Add Next Date'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}

function transfer_case(case_id) {
    // ajaxindicatorstart('loading modal.. please wait..');
    // ajax get modal
    $.ajax({
        url: getChangeCourtModald + "/" + case_id,
        success: function (data) {
            // ajaxindicatorstop();
            $('#show_modal_transfer').html(data);
            $('#modal-change-court').modal({
                backdrop: false,
                show: true,
            }); // show bootstrap modal
            $('.modal-title').text('Case Transfer'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}

function change_case_important(case_id) {
    // ajaxindicatorstart('loading modal.. please wait..');
    // ajax get modal
    $.ajax({
        url: getCaseImportantModald + '/' + case_id,
        success: function (data) {
            // ajaxindicatorstop();
            $('#show_modal').html(data);
            $('#modal-case-priority').modal({
                backdrop: false,
                show: true,
            }); // show bootstrap modal
            $('.modal-title').text('Change Case Important'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}

function getCourt(id) {
    if (id != '') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: getCourtd,
            method: "POST",
            data: {id: id},
            success: function (result) {
                if (result.errors) {
                    $('.alert-danger').html('');
                } else {
                    $('#court_name').html(result);
                }
            }
        });
    }
}

function downloadCaseBorad() {
    $date = $('#client_case').val();
    window.location.href = downloadCaseBoardd + "/" + $date;
}

function printCaseBorad() {
    $date = $('#client_case').val();

    window.open(printCaseBoardd + '/' + $date, '_blank');
}

