@extends('admin.layout.app')
@section('title','Invoice')
@section('content')

    <x-table-shell title="{{ __('frontend.invoice_management') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['invoice_add']))
                <x-action-button variant="primary" href="{{url('admin/create-Invoice-view')}}">
                    <i class="fa fa-plus me-1"></i>
                    {{__('frontend.add_invoice')}}
                </x-action-button>
            @endif
        </x-slot>

        <table id="client_list" class="w-full text-start text-sm text-dark">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
            <tr>
                <th width="3%" class="px-4 py-3">{{__('frontend.no')}}</th>
                <th width="15%" class="px-4 py-3">{{__('frontend.invoice_no')}}</th>
                <th width="30%" class="px-4 py-3">{{__('frontend.client_name')}}</th>
                <th width="10%" class="px-4 py-3">{{__('frontend.total')}}</th>
                <th width="10%" class="px-4 py-3">{{__('frontend.paid')}}</th>
                <th width="15%" class="px-4 py-3">{{__('frontend.due')}}</th>
                <th width="5%" class="px-4 py-3">{{__('frontend.status')}}</th>
                <th width="5%" class="px-4 py-3 text-center">{{__('frontend.action')}}</th>
            </tr>
            </thead>
        </table>
    </x-table-shell>

    <div id="load-modal"></div>

    <x-modal id="modal-common">
        <div id="show_modal"></div>
    </x-modal>

@endsection

@push('js')
    <input type="hidden" name="token-value" id="token-value" value="{{csrf_token()}}">
    <input type="hidden" name="invoice-list" id="invoice-list" value="{{ url('admin/invoice-list') }}">
    <script src="{{asset('assets/js/invoice/invoice-datatable.js')}}"></script>
@endpush
