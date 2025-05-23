"use strict";

var token = $('#token-value').val();
var case_ids = $('#case_ids').val();
var allCaseTransferLists = $('#allCaseTransferLists').val();

var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#case_transfer_list').DataTable({
            "processing": true,
            "serverSide": true,
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            "order": [[0, "desc"]],
            "ajax": {
                "url": allCaseTransferLists,
                "dataType": "json",
                "type": "POST",
                "data": {_token: token, case_id: case_ids}
            },
            "columns": [
                {"data": "id"},
                {"data": "registration_no"},
                {"data": "transfer_date"},
                {"data": "from"},
                {"data": "to"}
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
