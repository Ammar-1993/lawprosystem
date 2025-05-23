<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="clientPaymentreceivemodal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">{{__('frontend.add_payment')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.amount')}}<span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.receiving_date')}}<span class="text-danger">*</span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.payment_method')}} <span class="text-danger">*</span></label>
                        <select class="form-control">

                            <option>Cash</option>
                            <option>Cheque</option>

                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.reference_number')}}<span class="text-danger"></span></label>
                        <input type="text" placeholder="" class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="fullname">{{__('frontend.note')}}<span class="text-danger"></span></label>
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
</div>
