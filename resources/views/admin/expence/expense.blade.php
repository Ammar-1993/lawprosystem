@extends('admin.layout.app')
@section('title','Expense')
@section('content')

    <x-table-shell title="{{ __('frontend.manage_expense') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['expense_add']))
                <x-action-button variant="primary" href="{{ url('admin/expense-create') }}">
                    <i class="fa fa-plus me-1"></i> {{ __('frontend.add_expense') }}
                </x-action-button>
            @endif
        </x-slot>

        <table id="ExpenseDatatable" class="w-full text-start text-sm text-dark">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
                <tr>
                    <th width="3%" class="px-4 py-3">{{ __('frontend.no') }}</th>
                    <th width="15%" class="px-4 py-3">{{ __('frontend.invoice_no') }}</th>
                    <th width="30%" class="px-4 py-3">{{ __('frontend.vendor1') }}</th>
                    <th width="10%" class="px-4 py-3">{{ __('frontend.total') }}</th>
                    <th width="10%" class="px-4 py-3">{{ __('frontend.paid') }}</th>
                    <th width="15%" class="px-4 py-3">{{ __('frontend.due') }}</th>
                    <th width="5%" class="px-4 py-3">{{ __('frontend.status') }}</th>
                    <th width="5%" class="px-4 py-3 text-center">{{ __('frontend.action') }}</th>
                </tr>
            </thead>
        </table>
    </x-table-shell>

    <!-- Legacy JS hook container for injecting modals -->
    <div id="load-modal"></div>

    <input type="hidden" name="token-value" id="token-value" value="{{ csrf_token() }}">
    <input type="hidden" name="expense-list" id="expense-list" value="{{ url('admin/expense-list') }}">

@endsection

@push('js')
    <script src="{{ asset('assets/js/expense/expense-datatable.js') }}"></script>
@endpush
