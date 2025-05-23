<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="Detailmodal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">{{__('frontend.add_next_date')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="flat" checked="checked">&nbsp; {{__('frontend.declare_board_case')}}
                            </label>
                        </div>


                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.case_status')}} <span class="text-danger">*</span></label>
                        <select class="form-control">

                            <option>{{__('frontend.hearing')}}</option>
                            <option>{{__('frontend.fruther_statement')}}</option>

                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.next_date')}} <span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.remarks')}} <span class="text-danger"></span></label>
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
