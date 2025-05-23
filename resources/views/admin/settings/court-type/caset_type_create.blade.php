
  <div class="modal fade" id="addtag" role="dialog" aria-labelledby="addcategory" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form action="{{ route('court-type.store') }}" method="POST" id="tagForm" name="tagForm" >
            @csrf()
            <div class="modal-content">



                 <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel2">{{__('frontend.add_court_type')}}</h4>
            </div>

                <div class="modal-body">
                    <div id="form-errors"></div>
                    <div class="row">


          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
              <label for="case_subtype">{{__('frontend.court_type')}}<span class="text-danger">*</span></label>
              <input type="text" placeholder="" class="form-control" id="court_name" name="court_name">
          </div>
        </div>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="ik ik-x"></i>{{__('frontend.close')}}</button>
                    <button type="submit" class="btn btn-success shadow"><i class=" fa fa-save ik ik-check-circle" id="cl">
                        </i> {{__('frontend.save')}}</button>
                </div>

            </div>
        </form>
    </div>
</div>

  <input type="hidden" name="token-value"
         id="token-value"
         value="{{csrf_token()}}">

  <input type="hidden" name="common_check_exist"
         id="common_check_exist"
         value="{{ url('common_check_exist') }}">


  <script src="{{asset('assets/js/settings/cort-type-validation.js')}}"></script>


