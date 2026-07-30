@extends('admin.layout.app')
@section('title', 'Case Create')

@section('content')

    <div class="flex items-center justify-between mb-lg">
        <h3 class="text-2xl font-bold text-dark m-0">{{ __('frontend.add_case') }}</h3>
        <x-action-button variant="primary" href="{{ route('case-running.index') }}">
            {{ __('frontend.back') }}
        </x-action-button>
    </div>

    @if (count($errors) > 0)
        <div class="bg-danger text-white p-md rounded-md mb-lg">
            <strong>{{ __('frontend.whoops') }}</strong> {{ __('frontend.there_were_some_problems') }}<br><br>
            <ul class="ms-md mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" name="add_case" id="add_case" action="{{ route('case-running.store') }}">
        @csrf()

        <x-form-card title="{{ __('frontend.client_detail') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg">
                <div>
                    <label for="client_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.clientf') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" name="client_name" id="client_name">
                        <option value="">{{ __('frontend.select_client') }}</option>
                        @foreach ($client_list as $list)
                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-md pt-md">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" id="test1" name="position" value="Petitioner" checked class="text-primary focus:ring-primary border-gray-light">
                        <span class="ms-2 text-sm text-dark">{{ __('frontend.petitioner') }}</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" id="test2" name="position" value="Respondent" class="text-primary focus:ring-primary border-gray-light">
                        <span class="ms-2 text-sm text-dark">{{ __('frontend.respondent') }}</span>
                    </label>
                </div>
            </div>

            <div class="repeater">
                <div data-repeater-list="parties_detail">
                    <div data-repeater-item class="flex flex-wrap md:flex-nowrap items-end gap-md mb-md">
                        <div class="w-full md:w-5/12">
                            <label class="block text-sm font-semibold text-gray-dark mb-xs">
                                <b class="position_name">{{ __('frontend.respondent') }} Name</b> <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="party_name" name="party_name" data-rule-required="true" data-msg-required="{{ __('frontend.enter_name') }}" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                        </div>
                        <div class="w-full md:w-5/12">
                            <label class="block text-sm font-semibold text-gray-dark mb-xs">
                                <b class="position_advo">{{ __('frontend.respondent') }} Advocate</b> <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="party_advocate" name="party_advocate" data-rule-required="true" data-msg-required="{{ __('frontend.party_advocate') }}" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                        </div>
                        <div class="w-full md:w-2/12">
                            <x-action-button variant="danger" data-repeater-delete type="button" class="w-full">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </x-action-button>
                        </div>
                    </div>
                </div>
                <x-action-button variant="success" data-repeater-create type="button" class="mt-sm">
                    <i class="fa fa-plus me-1" aria-hidden="true"></i> {{ __('frontend.add_more') }}
                </x-action-button>
            </div>
        </x-form-card>

        <x-form-card title="{{ __('frontend.case_detail') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="case_no" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.case_no') }} <span class="text-danger">*</span></label>
                    <input type="text" id="case_no" name="case_no" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label for="case_type" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.case_type') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="case_type" name="case_type" onchange="getCaseSubType(this.value);">
                        <option value="">{{ __('frontend.select_case_type') }}</option>
                        @foreach ($caseTypes as $caseType)
                            <option value="{{ $caseType->id }}">{{ $caseType->case_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="case_sub_type" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.case_sub_type') }}</label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="case_sub_type" name="case_sub_type"></select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg">
                <div>
                    <label for="case_status" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.stage_of_case') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="case_status" name="case_status">
                        <option value="">{{ __('frontend.select_case_status') }}</option>
                        @foreach ($caseStatuses as $caseStatus)
                            <option value="{{ $caseStatus->id }}">{{ $caseStatus->case_status_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-md pt-md">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" id="test3" name="priority" value="High" class="text-primary focus:ring-primary border-gray-light">
                        <span class="ms-2 text-sm text-dark">{{ __('frontend.high') }}</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" id="test4" name="priority" value="Medium" checked class="text-primary focus:ring-primary border-gray-light">
                        <span class="ms-2 text-sm text-dark">{{ __('frontend.medium') }}</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" id="test5" name="priority" value="Low" class="text-primary focus:ring-primary border-gray-light">
                        <span class="ms-2 text-sm text-dark">{{ __('frontend.low') }}</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="act" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.act') }} <span class="text-danger">*</span></label>
                    <input type="text" id="act" name="act" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label for="filing_number" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.filing_number') }} <span class="text-danger">*</span></label>
                    <input type="text" id="filing_number" name="filing_number" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label for="filing_date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.filing_date') }} <span class="text-danger">*</span></label>
                    <input type="text" id="filing_date" name="filing_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent datetimepickerfilingdate" readonly="">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="registration_number" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.registration_number') }} <span class="text-danger">*</span></label>
                    <input type="text" id="registration_number" name="registration_number" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label for="filiregistration_dateng_date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.registration_date') }} <span class="text-danger">*</span></label>
                    <input type="text" id="filiregistration_dateng_date" name="registration_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent datetimepickerregdate" readonly="">
                </div>
                <div>
                    <label for="next_date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.first_hearing_date') }} <span class="text-danger">*</span></label>
                    <input type="text" id="next_date" name="next_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent datetimepickernextdate" readonly="">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-lg">
                <div class="md:col-span-1">
                    <label for="cnr_number" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.cnr_number') }}</label>
                    <input type="text" id="cnr_number" name="cnr_number" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div class="md:col-span-3">
                    <label for="description" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.description') }}</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"></textarea>
                </div>
            </div>
        </x-form-card>

        <x-form-card title="{{ __('frontend.fir_details') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                <div class="md:col-span-3">
                    <label for="police_station" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.police_station') }}</label>
                    <input type="text" id="police_station" name="police_station" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div class="md:col-span-1">
                    <label for="fir_number" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.fir_number') }}</label>
                    <input type="text" id="fir_number" name="fir_number" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div class="md:col-span-1">
                    <label for="fir_date" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.fir_date') }}</label>
                    <input type="text" id="fir_date" name="fir_date" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent datetimepickerregdate" readonly="">
                </div>
            </div>
        </x-form-card>

        <x-form-card title="{{ __('frontend.court_detail') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-lg">
                <div>
                    <label for="court_no" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.court_no') }} <span class="text-danger">*</span></label>
                    <input type="text" id="court_no" name="court_no" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label for="court_type" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.court_type') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="court_type" name="court_type" onchange="getCourt(this.value);">
                        <option value="">{{ __('frontend.select_court_type') }}</option>
                        @foreach ($courtTypes as $courtType)
                            <option value="{{ $courtType->id }}">{{ $courtType->court_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="court_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.court') }} <span class="text-danger">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="court_name" name="court_name"></select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-lg">
                <div>
                    <label for="judge_type" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.judge_name') }} <span class="text-danger">*</span></label>
                    <!-- select2 expects a wrapper, so we keep select2 class here -->
                    <select class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent select2" id="judge_type" name="judge_type">
                        <option value="">Select judge Name</option>
                        @foreach ($judges as $judge)
                            <option value="{{ $judge->id }}">{{ $judge->judge_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="judge_name" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.judge_type') }}</label>
                    <input type="text" id="judge_name" name="judge_name" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
            </div>

            <div class="grid grid-cols-1">
                <div>
                    <label for="remarks" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.remarks') }}</label>
                    <textarea id="remarks" name="remarks" rows="2" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"></textarea>
                </div>
            </div>
        </x-form-card>

        <x-form-card title="{{ __('frontend.task_assign') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                <div class="md:col-span-1">
                    <label for="assigned_to" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.users') }}</label>
                    <!-- multiple select could use select2, but checking original, it doesn't have select2 class, just multiple -->
                    <select multiple class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" id="assigned_to" name="assigned_to[]" style="min-height: 120px;">
                        @foreach ($users as $key => $val)
                            <option value="{{ $val->id }}">
                                {{ $val->first_name . ' ' . $val->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Card Footer Slot for Save/Cancel -->
            <x-slot name="footer">
                <x-action-button variant="danger" href="{{ route('case-running.index') }}">
                    {{ __('frontend.cancel') }}
                </x-action-button>
                <x-action-button variant="success" type="submit">
                    <i class="fa fa-save me-1" id="show_loader"></i> {{ __('frontend.save') }}
                </x-action-button>
            </x-slot>
        </x-form-card>

    </form>

    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
    <input type="hidden" name="getCaseSubType" id="getCaseSubType" value="{{ url('getCaseSubType') }}">
    <input type="hidden" name="getCourt" id="getCourt" value="{{ url('getCourt') }}">

@endsection

@push('js')
    <script>
        var caseValidationData = @json(__('backend.case'));
    </script>
    <script src="{{ asset('assets/js/case/case-add-validation.js') }}"></script>
    <script src="{{ asset('assets/admin/js/repeter/repeater.js') }}"></script>
@endpush
