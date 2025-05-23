@extends('admin.layout.app')
@section('title','Invoice Setting')
@push('style')

@endpush
@section('content')

    <div class="page-title"> 
        <div class="title_left">
            <h3>{{__('frontend.date_and_time_zone_setting')}}</h3>
        </div>


        <div class="title_right">
            <div class="form-group pull-right top_search">

            </div>
        </div>
    </div>
    <form id="mail_setup" name="mail_setup" role="form" method="POST"
          action="{{ route('date-timezone.update',$GeneralSettings->id) }}" enctype="multipart/form-data"
          autocomplete="off">
        @csrf()
        <input type="hidden" name="_method" value="PATCH">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        @include('admin.settings.setting-header')


                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">

                            </div>


                        </div>


                        <div class="row">


                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">{{__('frontend.date_format')}}</label><br>

                                <input type="radio" id="test3" name="forment"
                                       value="1" {{(!empty($GeneralSettings) && $GeneralSettings->date_formet=='1')?'checked':''}} {{empty($GeneralSettings)?'checked':''}}>
                                &nbsp;&nbsp;DD-MM-YYYY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="test4" name="forment"
                                       value="2" {{(!empty($GeneralSettings) && $GeneralSettings->date_formet=='2')?'checked':''}}>&nbsp;&nbsp;YYYY-MM-DD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="test5" name="forment"
                                       value="3" {{(!empty($GeneralSettings) && $GeneralSettings->date_formet=='3')?'checked':''}}>&nbsp;&nbsp;MM-DD-YYYY&nbsp;&nbsp;&nbsp;


                            </div>
                        </div>


                        <div class="row">
                            <br>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="timezone">{{__('frontend.timezone')}}<span class="text-danger">*</span></label>
                                <select name="timezone" id="timezone" class="form-control">

                                    @foreach($timezone as $t)
                                        <option value="{{ $t->zone_id }}"
                                                @if(isset($GeneralSettings) && $GeneralSettings->timezone== $t->zone_id) selected @endif>{{ $t->zone_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">

                                <button type="submit" class="btn btn-success" name="btn_add_smtp"><i class="fa fa-save"
                                                                                                     id="show_loader"></i>&nbsp;{{__('frontend.save')}}
                                </button>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </form>

@endsection



@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.checkImageSize.js')}}"></script>
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

    <script type="text/javascript">
        "use strict";
        $("#timezone").select2();
    </script>
@endpush
