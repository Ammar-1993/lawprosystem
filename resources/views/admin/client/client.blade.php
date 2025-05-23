@extends('admin.layout.app')
@section('title','Client')
@section('content')

    <div class="">
        
        @component('component.heading', [
    'page_title' => __('frontend.client.page_title'),
    'action' => route('clients.create'),
    'text' => __('frontend.client.add_client'),
    'permission' => $adminHasPermition->can(['client_add'])
])

        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">
                        <table id="clientDataTable" class="table" data-url="{{ route('clients.list') }}">
                            <thead>
                            <tr>
                                <th width="5%">{{__('frontend.client.no')}}</th>
                                <th>{{__('frontend.client.client_name')}}</th>
                                <th width="5%">{{__('frontend.client.mobile')}}</th>
                                <th width="5%" data-orderable="false">{{__('frontend.client.case')}}</th>
                                <th width="5%" data-orderable="false">{{__('frontend.client.status')}}</th>
                                <th width="5%" data-orderable="false" class="text-center">{{__('frontend.client.action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('js')

{{-- var dataTableLang = @json(__('datatable')); --}}


    <script src="{{asset('assets/js/client/client-datatable.js')}}"></script>
@endpush
