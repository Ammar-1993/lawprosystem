<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Modal Header</h4>
</div>
<form id="case_transfer" name="case_transfer" role="form" method="POST" action="{{ url('admin/transferCaseCourt')}}">
    {{ csrf_field() }}
    <input type="hidden" id="case_id" name="case_id" value="{{$case->id}}">
    <div class="modal-body">
        <div class="alert alert-danger change-cort-d"></div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label class="discount_text">{{__('frontend.court_number')}}<span class="text-danger">*</span></label>
                        <input type="text" id="court_number" name="court_number" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row change-m-bottom">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label class="discount_text">{{__('frontend.judge_type')}}<span class="text-danger">*</span></label>
                        <select class="form-control select2 selct2-width-100" id="judge_type" name="judge_type">
                            <option value="">Select judge</option>
                            @foreach($judges as $judge)
                                <option
                                        value="{{$judge->id}}" {{(!empty($case) && $case->judge_type==$judge->id)?'selected':''}}>{{$judge->judge_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label class="discount_text">{{__('frontend.judge_name')}}</label>
                        <input type="text" id="judge_name" name="judge_name" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label class="discount_text">{{__('frontend.transfer_date')}}<span class="text-danger">*</span></label>
                        <input type="text" id="transfer_date" name="transfer_date" class="form-control transfer_date"
                               readonly value="{{date($date_format_laravel)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                    class="ik ik-x"></i>{{__('frontend.close')}}
        </button>
        <button type="submit" name="case_transfer_btn" class="btn btn-success waves-effect waves-light">{{__('frontend.save')}} <i
                    class="fa fa-spinner fa-spin hide" id="btn_loader"></i></button>

    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('.transfer_date').datepicker({
            format: '{{$date_format_datepiker}}',
            todayHighlight: true,
            footer: true,
            modal: true,
            autoclose: true
        });
    });
</script>
<script src="{{asset('assets/js/case/change-model-validation.js')}}"></script>