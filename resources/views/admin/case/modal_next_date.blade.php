<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">{{__('frontend.add_next_date')}}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
</div>
<form  id="add_next_date" name="add_next_date" role="form" method="POST">
    {{ csrf_field() }}
    <input type="hidden" id="case_id" name="case_id" value="{{$case->id}}">
    <input type="hidden" id="business_on_date" name="business_on_date" value="{{$case->next_date}}"><div class="modal-body">
        <div class="alert alert-danger" style="display:none"></div>
        @php

            if($case->is_nb =='No' && $case->is_active =='Yes'){ @endphp
        <div class="row" id="hide_nb">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label class="notiseting">{{__('frontend.declare_board_case')}}
                            <input type="checkbox" value="Yes" name="is_nb" id="is_nb" onchange="nbCheck();">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @php } @endphp
        <div class="row" style="margin-bottom:15px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label class="discount_text">{{__('frontend.case_status')}}<span class="text-danger">*</span></label>
                        <select class="form-control select2" id="case_status" name="case_status" style="width:100%;">
                            <option value="">{{__('frontend.select_case_status')}}</option>
                            @foreach($caseStatuses as $caseStatus)
                                @php if($case->is_active=='No' && ($caseStatus->case_status_name=='Disposed' || $caseStatus->case_status_name=='Closed' )){ continue;} @endphp
                                <option value="{{$caseStatus->id}}" myvalue="{{$caseStatus->case_status_name}}" {{(!empty($case) && $case->case_status==$caseStatus->id && $case->is_active=='Yes')?'selected':''}}>{{$caseStatus->case_status_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="show_nextDate_div">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label  class="discount_text">{{__('frontend.next_date')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control case_next_date" id="next_date" name="next_date" readonly="">
                    </div>
                </div>
            </div>
        </div>
        <div id="hide_decisiondate" style="display: none;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="contct-info">
                        <div class="form-group">
                            <label  class="discount_text"> Decision date <span class="text-danger">*</span></label>
                            <input type="text" id="decision_date" name="decision_date" class="form-control datetimepickerdecisiondate" readonly="" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="contct-info">
                        <div class="form-group">
                            <label  class="discount_text">Nature of Disposal <span class="text-danger">*</span></label>
                            <input type="text" id="nature_disposal" name="nature_disposal" class="form-control"  value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="contct-info">
                    <div class="form-group">
                        <label  class="discount_text">{{__('frontend.remarks')}}</label>
                        <textarea  class="form-control" id="remarks" name="remarks"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                    class="ik ik-x"></i>{{__('frontend.close')}}</button>
        <button type="submit" name="case_next_date_btn" class="btn btn-success waves-effect waves-light">{{__('frontend.save')}} <i class="fa fa-spinner fa-spin hide" id="btn_loader"></i></button>

    </div>
</form>







<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
        var selected_option = $('#case_status option:selected').attr('myvalue');
        if(selected_option == 'Disposed' || selected_option == 'Closed'){
            $('#hide_nb').hide('slow');
        }else{
            $('#hide_nb').show('slow');
        }
        $('#case_status').on('change', function() {

            var option = $('#case_status option:selected').attr('myvalue');


            if(option == 'Disposed' || option == 'Closed'){


                $('#hide_nb').hide('slow');
                $('#show_nextDate_div').hide('slow');
                $('#hide_decisiondate').show('slow');

            }else{
                $('#hide_nb').show('slow');
                if ($('#is_nb').is(':checked')){

                }else{
                    $('#show_nextDate_div').show('slow');
                }

                $('#hide_decisiondate').hide('slow');

            }
        });

        $('.case_next_date').datepicker({
            format: '{{$date_format_datepiker}}',
            footer: true,
            todayHighlight:true,
            modal: true,
            autoclose:true,
            startDate:"{{date($date_format_laravel,strtotime($case->next_date. ' +1 day'))}}" });
        $('.datetimepickerdecisiondate').datepicker({
            format: '{{$date_format_datepiker}}',
            autoclose:"close",
            todayHighlight:true,
            clearBtn:true,
            startDate:"{{date($date_format_laravel,strtotime($case->next_date. ' +1 day'))}}"
        });
        $("#add_next_date").validate({
            rules: {
                case_status:"required",
                next_date: {
                    required:'#is_nb:unchecked'
                },
                decision_date:"required",
                nature_disposal:"required",

            },
            messages: {
                case_status:"Please select case status.",
                next_date: {
                    required:"Please select next date."
                },
                decision_date: "Please select decision date.",
                nature_disposal: "Please enter nature of disposal.",
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },

            submitHandler: function () {
                // Serialize the form data.

                var decision = $('#decision_date').val();

                var formData = $("#add_next_date").serialize();
                $('#btn_loader').removeClass('hide');
                $("button[name='case_next_date_btn']").attr("disabled", "disabled");
                //Add data using ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                $.ajax({
                    url: "{{ url('admin/case-next-date')}}",
                    method: "POST",
                    data: formData,
                    success: function (result) {

                        if (result.errors)
                        {
                            $('#btn_loader').addClass('hide');
                            $("button[name='case_next_date_btn']").removeAttr("disabled", "disabled").button('refresh');
                            $('.alert-danger').html('');

                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').css("display", "block");
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        }
                        else
                        {

                            $('.alert-danger').hide();
                            $('#modal-next-date').modal('hide');

                            $("#next_hear").load(" #next_hear");
                            if(decision != ''){
                                message.fire({
                                    type: 'success',
                                    title: 'Success' ,
                                    text:"Case disposed / closed successfully.",
                                });
                                // alert("Case disposed / closed successfully.");
                                // success_massage('Case disposed / closed successfully.');
                            }else{
                                message.fire({
                                    type: 'success',
                                    title: 'Success' ,
                                    text:"Case next date added successfully.",
                                });

                                // alert("Case next date added successfully.");
                                // success_massage('Case next date added successfully.');
                            }

                            location.reload();
                            if (typeof table === "undefined") {
                                location.reload();
                            } else {
                                table.ajax.reload();
                            }


                        }
                    }});
            }
        });
    });
    function nbCheck()
    {
        if($('#is_nb').is(":checked"))
            $("#show_nextDate_div").slideUp();
        else
            $("#show_nextDate_div").slideDown();
    }

</script>