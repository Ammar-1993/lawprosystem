<div class="x_title">
    <h2> {{__('frontend.case')}}</h2>
    <ul class="nav navbar-right panel_toolbox">
        <li>

            <a class="card-header-color"  href="{{url('admin/case-running-download/'.$case->case_id.'/download')}}"
               title="Download case file"><i class="fa fa-download fa-2x "></i></a>
        </li>
        <li>
            <a class="card-header-color"  href="{{url('admin/case-running-download/'.$case->case_id.'/print')}}"
               title="Print case file" target="_blank"><i class="fa fa-print fa-2x"></i></a>
        </li>

    </ul>
    <div class="clearfix"></div>
</div>

<br>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
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
                                                                 onClick="nextDateAdd({{$case->case_id}});"><i
                        class="fa fa-calendar"></i>{{__('frontend.update_next_date')}}</a>
            </li>
        @else
            <li role="presentation" class="pull-right udt-nd"><a href="javascript:void(0);"><i
                        class="fa fa-calendar"></i>{{__('frontend.update_next_date')}}</a>
            </li>
        @endif
    </ul>

</div>
