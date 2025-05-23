@extends('admin.layout.app')
@section('title', 'Judge')
@section('content')
    <div class="">

        @component('component.modal_heading', [
            'page_title' => __('frontend.judge_management'),
            'action' => route('judge.create'),
            'model_title' => __('frontend.add_judge'),
            'modal_id' => '#addtag',
            'permission' => $adminHasPermition->can(['judge_add']),
        ])
            {{__('frontend.status')}}
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="tagDataTable" class="table" data-url="{{ route('judge.list') }}">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('frontend.no')}}</th>
                                    <th>{{__('frontend.judge')}}</th>
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
    <script src="{{ asset('assets/js/settings/judge-datatable.js') }}"></script>
@endpush
