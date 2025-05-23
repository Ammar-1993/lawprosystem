"use strict";

var token = $('#token-value').val();
var case_ids = $('#case_ids').val();
var allCaseHistoryList = $('#allCaseHistoryList').val();

var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#case_history_list').DataTable({
            "processing": true,
            "serverSide": true,
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            "order": [[0, "asc"]],
            "ajax": {
                "url": allCaseHistoryList,
                "dataType": "json",
                "type": "POST",
                "data": {_token: token, case_id: case_ids}
            },
            "columns": [
                {"data": "registration_no"},
                {"data": "judge"},
                {"data": "business_on_date"},
                {"data": "hearing_date"},
                {"data": "purpose_of_hearing"},
                {"data": "remarks"}
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


        })

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


function showRemark(bussinessOnDate, remarks) {

    $('.modal-body').html(remarks);

    $('#remarkModal').modal('show'); // show bootstrap modal

    $('.modal-title').text('Remark of Business on Date : ' + bussinessOnDate); // Set Title to Bootstrap modal title
}
