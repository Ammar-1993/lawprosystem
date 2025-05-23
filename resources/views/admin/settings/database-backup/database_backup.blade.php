@extends('admin.layout.app')
@section('title', 'Tax')
@section('content')
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3>Database Backup</h3>
            </div>
            <div class="title_right">
                <div class="form-group pull-right top_search">

                    <a href="{{ url('admin/database-backups') }}" class="btn btn-primary "><i class="fa fa-database"></i>
                        Backup</a>


                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="tagDataTable" class="table" data-url="{{ route('database-backup.list') }}">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('frontend.no')}}</th>
                                    <th>{{__('frontend.date')}}</th>
                                    <th width="2%" data-orderable="false" class="text-center">{{__('frontend.action')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>
@endsection

@push('js')
    <script>
        "use strict";
        var table = $('#tagDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            "oLanguage": {
                sProcessing: "<div class='loader-container'><div id='loader'></div></div>"
            },
            "width": 200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#tagDataTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
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
                    "data": "date"
                },
                {
                    "data": "action"
                }
            ]
        });
    </script>
@endpush
