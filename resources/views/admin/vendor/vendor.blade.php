@extends('admin.layout.app')
@section('title','Vendor')
@section('content')
    <div class="">
        @component('component.heading' , [

  'page_title' => __('frontend.vendor_management'),
  'action' => route('vendor.create') ,
  'text' => __('frontend.add_vendor'),
   'permission' => $adminHasPermition->can(['vendor_add'])
   ])
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="Vendordatatable" class="table"
                               data-url="{{ route('vendor.list') }}">
                            <thead>
                            <tr>
                                <th>{{__('frontend.no')}}</th>
                                <th width="40%">{{__('frontend.name')}}</th>
                                <th width="40%">{{__('frontend.mobile')}}</th>
                                <th data-orderable="false">{{__('frontend.status')}}</th>
                                <th data-orderable="false">{{__('frontend.action')}}</th>
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
    <script src="{{asset('assets/js/vendor/vendor-datatable.js')}}"></script>
@endpush
