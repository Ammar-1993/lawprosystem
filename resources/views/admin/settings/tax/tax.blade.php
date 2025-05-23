@extends('admin.layout.app')
@section('title', 'Tax')
@section('content')
    <div class="">

        @component('component.modal_heading', [
            'page_title' => __('frontend.tax_management'),
            'action' => route('tax.create'),
            'model_title' => __('frontend.add_tax'),
            'modal_id' => '#addtag',
            'permission' => $adminHasPermition->can(['tax_add']),
        ])
            {{__('frontend.status')}}
        @endcomponent



        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="tagDataTable" class="table" data-url="{{ route('tax.list') }}">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('frontend.no')}}</th>
                                    <th>{{__('frontend.name')}}</th>

                                    <th width="5%">{{__('frontend.percentage')}}</th>
                                    <th width="5%" data-orderable="false">{{__('frontend.status')}}</th>
                                    <th width="2%" data-orderable="false" class="text-center">{{__('frontend.action')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/settings/tax-datatable.js') }}"></script>
@endpush
