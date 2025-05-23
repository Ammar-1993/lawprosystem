<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="clientTransfermodal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">{{ __('frontend.client.case_transfer') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{ __('frontend.client.court_number') }} <span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{ __('frontend.client.aD_HOC_aDDL_district') }} <span class="text-danger">*</span></label>
                        <select class="form-control">

                            <option>{{ __('frontend.client.aDDL_gistrict_sessions_judge') }}</option>
                            <option>{{ __('frontend.client.judge_type') }}</option>

                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{ __('frontend.client.judge_name') }} <span class="text-danger"></span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{ __('frontend.client.transfer_date') }} <span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('frontend.client.close') }}</button>
                    <button type="button" class="btn btn-primary">{{ __('frontend.client.save') }}</button>
                </div>

            </div>
        </div>
    </div>
</div>
