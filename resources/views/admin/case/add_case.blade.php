@extends('admin.layout.app')
@section('title', 'Case Create')


@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>{{ __('frontend.add_case') }}</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ route('case-running.index') }}" class="btn btn-primary">{{ __('frontend.back') }}</a>

            </div>
        </div>
    </div>
    <!------------------------------------------------ ROW 1-------------------------------------------- -->


    <form method="post" name="add_case" id="add_case" action="{{ route('case-running.store') }}" class="">
        @csrf()
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('frontend.client_detail') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>{{ __('frontend.whoops') }}</strong>{{ __('frontend.there_were_some_problems') }}<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.clientf') }}<span class="text-danger">*</span></label>
                                <select class="form-control" name="client_name" id="client_name">
                                    <option value="">{{ __('frontend.select_client') }}</option>
                                    @foreach ($client_list as $list)
                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <br><br>
                                <input type="radio" id="test1" name="position" value="Petitioner" checked>&nbsp;&nbsp;
                                {{ __('frontend.petitioner') }}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="test2" name="position" value="Respondent">&nbsp;&nbsp;
                                {{ __('frontend.respondent') }}
                            </div>
                        </div>


                        <div class="repeater">
                            <div data-repeater-list="parties_detail">
                                <div data-repeater-item>
                                    <div class="row">

                                        <div class="col-md-6">


                                            <div class="form-group">
                                                <label class="discount_text "> <b
                                                        class="position_name">{{ __('frontend.respondent') }}
                                                        Name </b><span class="text-danger">*</span></label>
                                                <input type="text" id="party_name" name="party_name"
                                                    data-rule-required="true"
                                                    data-msg-required="{{ __('frontend.enter_name') }}" class="form-control">
                                            </div>


                                        </div>

                                        <div class="col-md-5">

                                            <div class="form-group">
                                                <label class="discount_text "><b
                                                        class="position_advo">{{ __('frontend.respondent') }}
                                                        Advocate</b><span class="text-danger">*</span></label>
                                                <input type="text" id="party_advocate" name="party_advocate"
                                                    data-rule-required="true"
                                                    data-msg-required="{{ __('frontend.party_advocate') }}"
                                                    class="form-control">
                                            </div>


                                        </div>

                                        <div class="col-md-1">

                                            <div class="form-group">

                                                <div class="case-margin-top-23"></div>
                                                <button type="button" data-repeater-delete type="button"
                                                    class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"
                                                        aria-hidden="true"></i></button>
                                            </div>


                                        </div>


                                    </div>

                                    <br>
                                </div>
                            </div>
                            <button data-repeater-create type="button" value="Add New"
                                class="btn btn-success waves-effect waves-light btn btn-success-edit" type="button">
                                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{{ __('frontend.add_more') }}
                            </button>
                        </div>


                    </div>
                </div>

            </div>

        </div>
        <!------------------------------------------------------- End ROw --------------------------------------------->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('frontend.case_detail') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.case_no') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="case_no" name="case_no" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.case_type') }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="case_type" name="case_type"
                                    onchange="getCaseSubType(this.value);">
                                    <option value="">{{ __('frontend.select_case_type') }}</option>
                                    @foreach ($caseTypes as $caseType)
                                        <option value="{{ $caseType->id }}">{{ $caseType->case_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.case_sub_type') }}<span
                                        class="text-danger"></span></label>
                                <select class="form-control" id="case_sub_type" name="case_sub_type"></select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.stage_of_case') }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="case_status" name="case_status">
                                    <option value="">{{ __('frontend.select_case_status') }}</option>
                                    @foreach ($caseStatuses as $caseStatus)
                                        <option value="{{ $caseStatus->id }}">{{ $caseStatus->case_status_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <br><br>
                                <input type="radio" id="test3" name="priority"
                                    value="High">&nbsp;&nbsp;{{ __('frontend.high') }}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="test4" name="priority" value="Medium"
                                    checked>&nbsp;&nbsp;{{ __('frontend.medium') }}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="test5" name="priority"
                                    value="Low">&nbsp;&nbsp;{{ __('frontend.low') }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.act') }} <span class="text-danger">*</span></label>
                                <input type="text" id="act" name="act" class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.filing_number') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="filing_number" name="filing_number" class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.filing_date') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="filing_date" name="filing_date"
                                    class="form-control datetimepickerfilingdate" readonly="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.registration_number') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="registration_number" name="registration_number"
                                    class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.registration_date') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="filiregistration_dateng_date" name="registration_date"
                                    class="form-control datetimepickerregdate" readonly="">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.first_hearing_date') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="next_date" name="next_date"
                                    class="form-control datetimepickernextdate" readonly="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.cnr_number') }}<span
                                        class="text-danger"></span></label>
                                <input type="text" id="cnr_number" name="cnr_number" class="form-control">
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.description') }}<span
                                        class="text-danger"></span></label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('frontend.fir_details') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.police_station') }}<span
                                        class="text-danger"></span></label>
                                <input type="text" id="police_station" name="police_station" class="form-control">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.fir_number') }}<span
                                        class="text-danger"></span></label>
                                <input type="text" id="fir_number" name="fir_number" class="form-control">
                            </div>


                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.fir_date') }}<span
                                        class="text-danger"></span></label>
                                <input type="text" id="fir_date" name="fir_date"
                                    class="form-control datetimepickerregdate" readonly="">
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('frontend.court_detail') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.court_no') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="court_no" name="court_no" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.court_type') }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="court_type" name="court_type"
                                    onchange="getCourt(this.value);">
                                    <option value="">{{ __('frontend.select_court_type') }}</option>
                                    @foreach ($courtTypes as $courtType)
                                        <option value="{{ $courtType->id }}">{{ $courtType->court_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.court') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="court_name" name="court_name"></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.judge_name') }}<span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="judge_type" name="judge_type">
                                    <option value="">Select judge Name</option>
                                    @foreach ($judges as $judge)
                                        <option value="{{ $judge->id }}">{{ $judge->judge_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.judge_type') }}<span
                                        class="text-danger"></span></label>
                                <input type="text" id="judge_name" name="judge_name" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.remarks') }}<span
                                        class="text-danger"></span></label>
                                <textarea id="remarks" name="remarks" class="form-control"></textarea>

                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('frontend.task_assign') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">


                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{ __('frontend.users') }}</label>
                                <select multiple class="form-control" id="assigned_to" name="assigned_to[]">
                                    @foreach ($users as $key => $val)
                                        <option value="{{ $val->id }}">
                                            {{ $val->first_name . ' ' . $val->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                    </div>
                </div>

            </div>


            <div class="form-group pull-right">
                <div class="col-md-12 col-sm-6 col-xs-12">


                    <a class="btn btn-danger" href="{{ route('case-running.index') }}">{{ __('frontend.cancel') }}</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"
                            id="show_loader"></i>&nbsp;{{ __('frontend.save') }}
                    </button>
                </div>

            </div>
            <br>

        </div>
    </form>
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">

    <input type="hidden" name="getCaseSubType" id="getCaseSubType" value="{{ url('getCaseSubType') }}">

    <input type="hidden" name="getCourt" id="getCourt" value="{{ url('getCourt') }}">
@endsection

@push('js')
    {{-- الكود الجديد لتمرير رسائل التحقق والنصوص الأخرى --}}
    <script>
        var caseValidationData = @json(__('backend.case'));
        // إذا كنت تحتاج إلى رسائل عامة أخرى من common_js (مثلاً لعناوين SweetAlert العامة)
        // var commonJsLang = @json(__('backend.common_js'));
    </script>
    {{-- نهاية الكود الجديد --}}

    <script src="{{ asset('assets/js/case/case-add-validation.js') }}"></script>
    <script src="{{ asset('assets/admin/js/repeter/repeater.js') }}"></script>
@endpush
