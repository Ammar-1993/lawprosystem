@extends('admin.layout.app')
@section('title', 'Appointment')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/jquery-confirm-master/css/jquery-confirm.css') }}">
@endpush
@section('content')

    <x-table-shell title="{{ __('frontend.appointment.appointment_management') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['appointment_add']))
                <x-action-button variant="primary" href="{{ route('appointment.create') }}">
                    <i class="fa fa-plus me-1"></i>
                    {{ __('frontend.appointment.add_appointment') }}
                </x-action-button>
            @endif
        </x-slot>

        <x-slot name="filters">
            <div class="flex flex-wrap items-end gap-md">
                <!-- Note: Preserving the duplicate id="date_to" due to legacy JS constraints -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.appointment.from_date') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent dateTo" id="date_to" autocomplete="off" readonly="">
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-dark mb-xs">{{ __('frontend.appointment.to_date') }}</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-light rounded-md focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent dateTo" id="date_to" autocomplete="off" readonly="">
                </div>

                <div class="flex gap-sm">
                    <x-action-button variant="danger" type="button" id="btn_clear" name="btn_clear">
                        {{ __('frontend.appointment.clear') }}
                    </x-action-button>
                    <x-action-button variant="success" type="submit" id="search">
                        <i class="fa fa-search me-1"></i> {{ __('frontend.appointment.search') }}
                    </x-action-button>
                </div>
            </div>
        </x-slot>

        <table id="Appointmentdatatable" class="w-full text-start text-sm text-dark appointment_table" data-url="{{ route('appointment.list') }}">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">{{ __('frontend.appointment.no') }}</th>
                    <th width="40%" class="px-4 py-3">{{ __('frontend.appointment.client_name') }}</th>
                    <th width="10%" class="px-4 py-3">{{ __('frontend.appointment.mobile') }}</th>
                    <th width="10%" class="px-4 py-3">{{ __('frontend.appointment.date') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.appointment.time') }}</th>
                    <th class="px-4 py-3" data-orderable="false">{{ __('frontend.appointment.status') }}</th>
                    <th class="px-4 py-3 text-center" data-orderable="false">{{ __('frontend.appointment.action') }}</th>
                </tr>
            </thead>
        </table>
    </x-table-shell>

    <input type="hidden" name="token-value" id="token-value" value="{{ csrf_token() }}">
    <input type="hidden" name="date_format_datepiker" id="date_format_datepiker" value="{{ $date_format_datepiker }}">
    <input type="hidden" name="common_change_state" id="common_change_state" value="{{ url('common_change_state') }}">

@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('assets/admin/jquery-confirm-master/js/jquery-confirm.js') }}"></script>
    <script src="{{ asset('assets/js/appointment/appointment-datatable.js') }}"></script>
@endpush
