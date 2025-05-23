"use strict";

var token = $('#token-value').val();
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#Vendordatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            "width": 200,
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            // "scrollY":        "500px",
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#Vendordatatable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {});
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                "data": "id"
            },

                {
                    "data": "first_name"
                },
                {
                    "data": "mobile"
                },
                {
                    "data": "is_active"
                },
                {
                    "data": "action"
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
