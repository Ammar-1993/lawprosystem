@extends('admin.layout.app')
@section('title','Client')
@section('content')

    <x-table-shell title="{{ __('frontend.client.page_title') }}">
        <x-slot name="action">
            @if($adminHasPermition->can(['client_add']))
                <x-action-button variant="primary" href="{{ route('clients.create') }}">
                    <i class="fa fa-plus me-1"></i>
                    {{ __('frontend.client.add_client') }}
                </x-action-button>
            @endif
        </x-slot>

        <table id="clientDataTable" class="w-full text-start text-sm text-dark" data-url="{{ route('clients.list') }}">
            <thead class="bg-gray-50 border-b border-gray-light text-gray-dark uppercase text-xs">
            <tr>
                <th width="5%" class="px-4 py-3">{{__('frontend.client.no')}}</th>
                <th class="px-4 py-3">{{__('frontend.client.client_name')}}</th>
                <th width="5%" class="px-4 py-3">{{__('frontend.client.mobile')}}</th>
                <th width="5%" class="px-4 py-3" data-orderable="false">{{__('frontend.client.case')}}</th>
                <th width="5%" class="px-4 py-3" data-orderable="false">{{__('frontend.client.status')}}</th>
                <th width="5%" class="px-4 py-3 text-center" data-orderable="false">{{__('frontend.client.action')}}</th>
            </tr>
            </thead>
        </table>
    </x-table-shell>
    
@endsection
@push('js')
    <script src="{{asset('assets/js/client/client-datatable.js')}}"></script>
@endpush
