<div class="x_title">
    <h2> {{__('frontend.case')}}</h2>
    <ul class="nav navbar-right panel_toolbox">
        <li>
            <a class="btn btn-primary lp-btn lp-btn-primary" style="padding: 6px 12px; margin-right: 5px;" href="{{url('admin/case-running-download/'.$case->case_id.'/download')}}"
               title="Download case file"><i class="fa fa-download"></i></a>
        </li>
        <li>
            <a class="btn btn-primary lp-btn lp-btn-primary" style="padding: 6px 12px;" href="{{url('admin/case-running-download/'.$case->case_id.'/print')}}"
               title="Print case file" target="_blank"><i class="fa fa-print"></i></a>
        </li>
    </ul>
    <div class="clearfix"></div>
</div>

<br>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs lp-tabs" role="tablist">
        <li role="presentation" class="@if(Request::segment(2)=='case-running')active @ else @endif"><a
                href="{{route('case-running.show',$case->case_id)}}">{{__('frontend.detail')}}</a>
        </li>
        <li role="presentation" class="@if(Request::segment(4)=='histroy')active @ else @endif"><a
                href="{{url( 'admin/case-history/'.$case->case_id)}}">{{__('frontend.history')}}</a>

        </li>
        <li role="presentation" class="@if(Request::segment(4)=='transfer')active @ else @endif"><a
                href="{{url('admin/case-transfer/'.$case->case_id)}}">{{__('frontend.transfer')}}</a>
        </li>
        @if($adminHasPermition->can(['case_edit']) =="1")
            <li role="presentation" class="pull-right udt-nd"><a href="javascript:void(0);"
                                                                 onClick="nextDateAdd({{$case->case_id}});" class="btn btn-primary lp-btn lp-btn-primary" style="margin-top: 5px; color: white !important;"><i
                        class="fa fa-calendar"></i> {{__('frontend.update_next_date')}}</a>
            </li>
        @else
            <li role="presentation" class="pull-right udt-nd"><a href="javascript:void(0);" class="btn btn-primary lp-btn lp-btn-primary" style="margin-top: 5px; color: white !important;"><i
                        class="fa fa-calendar"></i> {{__('frontend.update_next_date')}}</a>
            </li>
        @endif
    </ul>

</div>
