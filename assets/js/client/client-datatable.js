"use strict";
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#clientDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            "oLanguage": {sProcessing: "<div class='loader-container'><div id='loader'></div></div>"},
            "width": 200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#clientDataTable').attr('data-url'),
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
                    "data": "case"
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
