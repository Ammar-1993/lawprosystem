@extends('admin.layout.app')
@section('title','Client Account')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h4>{{ __('frontend.client.client_name') }}  : {{$name}} </h4>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="{{ request()->is('admin/clients/*') ? 'active' : '' }}"><a
                                href="{{ route('clients.show', [$client->id]) }}">{{ __('frontend.client.client_detail') }} </a>
                        </li>

                        @if($adminHasPermition->can(['case_list']) =="1")
                            <li class="{{ request()->is('admin/client/case-list/*') ? 'active' : '' }}"
                                role="presentation"><a href="{{route('clients.case-list',[$client->id])}}">{{ __('frontend.client.cases') }}</a>
                            </li>
                        @endif


                        @if($adminHasPermition->can(['invoice_list']) =="1")
                            <li class="{{ request()->is('admin/client/account-list/*') ? 'active' : '' }}"
                                role="presentation"><a
                                    href="{{route('clients.account-list',[$client->id])}}">{{ __('frontend.client.account') }}</a>
                            </li>
                        @endif
                    </ul>


                </div>

                <div class="x_content">

                    <table id="clientAccountlistDatatable" class="table" data-url="{{ route('invoice-list-client') }}"
                           >
                        <thead>
                        <tr>
                            <th>{{ __('frontend.client.no') }}</th>
                            <th>{{ __('frontend.client.invoice_no') }}</th>
                            <th>{{ __('frontend.client.client_name') }}</th>
                            <th data-orderable="false">{{ __('frontend.client.total') }}</th>
                            <th>{{ __('frontend.client.paid') }}</th>
                            <th data-orderable="false">{{ __('frontend.client.due') }}</th>
                            <th data-orderable="false">{{ __('frontend.client.status') }}</th>
                            <th data-orderable="false">{{ __('frontend.client.action') }}</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>

    <input type="hidden" name="advo_client_id"
           id="advo_client_id"
           value="{{$advo_client_id}}">

    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">

@endsection
@push('js')
    <script src="{{asset('assets/js/client/client-account-datatable.js')}}"></script>
@endpush
