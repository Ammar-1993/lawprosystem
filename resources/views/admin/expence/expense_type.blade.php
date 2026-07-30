@extends('admin.layout.app')
@section('title','Expense Type')
@section('content')

    <x-table-shell title="{{ __('frontend.expense_type_management') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['expense_type_add']))
                <x-action-button variant="primary" href="{{ route('expense-type.create') }}">
                    <i class="fa fa-plus me-1"></i> {{ __('frontend.add_expense_type') }}
                </x-action-button>
            @endif
        </x-slot>

        <table id="tagDataTable" class="w-full text-start text-sm text-dark" data-url="{{ route('expense.type.list') }}">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
                <tr>
                    <th width="5%" class="px-4 py-3">{{ __('frontend.no') }}</th>
                    <th class="px-4 py-3">{{ __('frontend.name') }}</th>
                    <th width="5%" class="px-4 py-3" data-orderable="false">{{ __('frontend.status') }}</th>
                    <th width="5%" class="px-4 py-3 text-center" data-orderable="false">{{ __('frontend.action') }}</th>
                </tr>
            </thead>
        </table>
    </x-table-shell>

    <!-- Legacy JS hook container for injecting modals -->
    <div id="load-modal"></div>

@endsection

@push('js')
    <script src="{{ asset('assets/js/expense/expense-type-datatable.js') }}"></script>
@endpush
