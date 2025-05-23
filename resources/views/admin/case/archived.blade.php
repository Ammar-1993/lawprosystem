@extends('admin.layout.app')
@section('title','Case')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{__('frontend.cases_management')}}</h3>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">
                    @if($adminHasPermition->can(['case_add']))
                        <a href="{{ route('case-running.create') }}" class="btn btn-primary">{{__('frontend.add_case')}}</a>
                    @endif

                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <div class="row">


                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{__('frontend.from_next_date')}} <span class="text-danger"></span></label>
                                <input type="text" class="form-control dateFrom" id="date_from" readonly="">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{__('frontend.to_next_date')}}<span class="text-danger"></span></label>
                                <input type="text" class="form-control dateTo" id="date_to" readonly="">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">


                                <div class="case-margin-top-23"></div>
                                <a href="#" class="btn btn-danger" id="clear">{{__('frontend.clear')}}</a>
                                <button type="submit" id="search" disabled="disabled" class="btn btn-success"><i
                                        class="fa fa-search"></i>{{__('frontend.search')}}
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                                <li role="presentation" class="{{(Request::is('admin/case-running'))?'active':''}} ">
                                    <a href="{{url('admin/case-running')}}">{{__('frontend.running_cases')}}</a>
                                </li>

                                <li role="presentation" class="{{(Request::is('admin/case-important'))?'active':''}} ">
                                    <a href="{{url('admin/case-important')}}">{{__('frontend.important_cases')}}</a>
                                </li>

                                <li role="presentation" class="{{(Request::is('admin/case-nb'))?'active':''}} ">
                                    <a href="{{url('admin/case-nb')}}">{{__('frontend.no_board_cases')}}</a>
                                </li>
                                <li role="presentation" class="{{(Request::is('admin/case-archived'))?'active':''}} ">
                                    <a href="{{url('admin/case-archived')}}">{{__('frontend.archived_cases')}}</a>
                                </li>

                            </ul>

                        </div>

                        <table id="case_list" class="table row-border">
                            <thead>
                            <tr>
                                <th width="3%">{{__('frontend.no')}}</th>
                                <th width="20%">{{__('frontend.client_case_detail')}}</th>
                                <th width="35%">{{__('frontend.court_detail')}}</th>
                                <th width="20%">{{__('frontend.petitioner_respondent')}}</th>
                                <th width="10%">{{__('frontend.next_date')}}</th>
                                <th width="9%">{{__('frontend.status')}}</th>
                                <th width="3%">{{__('frontend.action')}}</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <!-- /page content end  -->


    <div class="modal fade" id="modal-case-priority" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="show_modal">

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-change-court" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="show_modal_transfer">

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-next-date" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="show_modal_next_date">

            </div>
        </div>
    </div>
    <input type="hidden" name="get_case_important_modal"
           id="get_case_important_modal"
           value="{{url('admin/getCaseImportantModal')}}">

    <input type="hidden" name="get_case_next_modal"
           id="get_case_next_modal"
           value="{{url('admin/getNextDateModal')}}">

    <input type="hidden" name="get_case_cort_modal"
           id="get_case_cort_modal"
           value="{{url('admin/getChangeCourtModal')}}">

    <input type="hidden" name="case_url"
           id="case_url"
           value="{{ url('admin/allCaseList') }}">

    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">

    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">
@endsection

@push('js')
    <script src="{{asset('assets/js/case/case-archive-datatable.js')}}"></script>
@endpush
