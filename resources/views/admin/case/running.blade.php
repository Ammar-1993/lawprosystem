@extends('admin.layout.app')
@section('title','Case')

@section('content')

    <x-table-shell title="{{ __('frontend.cases_management') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['case_add']))
                <x-action-button variant="primary" href="{{ route('case-running.create') }}">
                    <i class="fa fa-plus me-1"></i>
                    {{ __('frontend.add_case') }}
                </x-action-button>
            @endif
        </x-slot>

        <x-slot name="filters">
            <!-- Tabs (Running, Important, No Board, Archived) -->
            <div class="mb-md border-b border-gray-light pb-2">
                <nav class="flex gap-4">
                    <a href="{{ url('admin/case-running') }}" class="font-semibold pb-2 border-b-2 {{ Request::is('admin/case-running') ? 'border-primary text-primary' : 'border-transparent text-gray-dark hover:text-primary' }} transition-colors">
                        {{ __('frontend.running_cases') }}
                    </a>
                    <a href="{{ url('admin/case-important') }}" class="font-semibold pb-2 border-b-2 {{ Request::is('admin/case-important') ? 'border-primary text-primary' : 'border-transparent text-gray-dark hover:text-primary' }} transition-colors">
                        {{ __('frontend.important_cases') }}
                    </a>
                    <a href="{{ url('admin/case-nb') }}" class="font-semibold pb-2 border-b-2 {{ Request::is('admin/case-nb') ? 'border-primary text-primary' : 'border-transparent text-gray-dark hover:text-primary' }} transition-colors">
                        {{ __('frontend.no_board_cases') }}
                    </a>
                    <a href="{{ url('admin/case-archived') }}" class="font-semibold pb-2 border-b-2 {{ Request::is('admin/case-archived') ? 'border-primary text-primary' : 'border-transparent text-gray-dark hover:text-primary' }} transition-colors">
                        {{ __('frontend.archived_cases') }}
                    </a>
                </nav>
            </div>

            <!-- Date Filters -->
            <div class="flex flex-wrap items-end gap-md mt-md">
                <div class="w-full sm:w-auto flex-1">
                    <label for="date_from" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.from_next_date') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent dateFrom" id="date_from" readonly="">
                </div>
                
                <div class="w-full sm:w-auto flex-1">
                    <label for="date_to" class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.to_next_date') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent dateTo" id="date_to" readonly="">
                </div>
                
                <div class="w-full sm:w-auto flex gap-2">
                    <x-action-button variant="danger" id="clear">
                        {{ __('frontend.clear') }}
                    </x-action-button>
                    <x-action-button variant="success" id="search" disabled="disabled">
                        <i class="fa fa-search me-1"></i> {{ __('frontend.search') }}
                    </x-action-button>
                </div>
            </div>
        </x-slot>

        <table id="case_list" class="w-full text-start text-sm text-dark">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
                <tr>
                    <th width="3%" class="px-4 py-3">{{ __('frontend.no') }}</th>
                    <th width="20%" class="px-4 py-3">{{ __('frontend.client_case_detail') }}</th>
                    <th width="35%" class="px-4 py-3">{{ __('frontend.court_detail') }}</th>
                    <th width="20%" class="px-4 py-3">{{ __('frontend.petitioner_respondent') }}</th>
                    <th width="10%" class="px-4 py-3">{{ __('frontend.next_date') }}</th>
                    <th width="9%" class="px-4 py-3">{{ __('frontend.status') }}</th>
                    <th width="3%" class="px-4 py-3">{{ __('frontend.action') }}</th>
                </tr>
            </thead>
        </table>
    </x-table-shell>

    <!-- Modals using the bridging <x-modal> component -->
    <x-modal id="modal-case-priority" targetId="show_modal" />
    <x-modal id="modal-change-court" targetId="show_modal_transfer" />
    <x-modal id="modal-next-date" targetId="show_modal_next_date" />

    <!-- Hidden inputs for datatable (DO NOT TOUCH) -->
    <input type="hidden" name="get_case_important_modal" id="get_case_important_modal" value="{{url('admin/getCaseImportantModal')}}">
    <input type="hidden" name="get_case_next_modal" id="get_case_next_modal" value="{{url('admin/getNextDateModal')}}">
    <input type="hidden" name="get_case_cort_modal" id="get_case_cort_modal" value="{{url('admin/getChangeCourtModal')}}">
    <input type="hidden" name="case_url" id="case_url" value="{{ url('admin/allCaseList') }}">
    <input type="hidden" name="token-value" id="token-value" value="{{csrf_token()}}">
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{$date_format_datepiker}}">

@endsection

@push('js')
    <script src="{{asset('assets/js/case/case-datatable.js')}}"></script>
@endpush
