<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="Casetransfermodal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">{{__('frontend.case_transfer')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.court_number')}} <span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.judge_type')}}<span class="text-danger">*</span></label>
                        <select class="form-control">

                            <option>AD-HOC ADDL District & Session Judge</option>
                            <option>ADDL District & Sessions Judge</option>

                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.judge_name')}}<span class="text-danger"></span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.transfer_date')}}<span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('frontend.close')}}</button>
                    <button type="button" class="btn btn-primary">{{__('frontend.save')}}</button>
                </div>

            </div>
        </div>
    </div>
