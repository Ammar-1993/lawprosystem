"use strict";

function checkDependency() {
    var getVal = $("#method").val();
    if (getVal == 'Cash' || getVal == '') {
        return false;
    } else {
        return true;
    }
}

function checkDateDependency() {
    var getVal = $("#method").val();
    if (getVal != 'Cheque') {
        return false;
    } else {
        return true;
    }
}

var token = $('#token-value').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var method_ = $('#method_').val();
var url = $('#url').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#form_payment").validate({
            rules: {
                amount: {
                    required: true,
                    number: true
                },
                receive_date: {
                    required: true,
                },
                referance_number: {
                    required: function (element) {
                        return checkDependency;
                    }
                },
                cheque_date: {
                    required: function (element) {
                        return checkDateDependency;
                    }
                },
                method: {
                    required: true,
                }

            },
            messages: {
                amount: {
                    required: "Please enter amount.",
                    number: "please enter digit 0-9."
                },
                receive_date: {
                    required: "Please select date.",
                },
                referance_number: {
                    required: "Please enter reference no.",
                },
                cheque_date: {
                    required: "Please select date.",
                },
                method: {
                    required: "Please select payment method.",
                }
            },

            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            }, submitHandler: function () {
                $('#btn_loader').removeClass('hide');
                $("button[name='judge_type_btn']").attr("disabled", "disabled");
                //Add data using ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: url,
                    method: method_,
                    data: {
                        amount: $('#amount').val(),
                        receive_date: $('#receive_date').val(),
                        cheque_date: $('#cheque_date').val(),
                        method: $('#method').val(),
                        referance_number: $('#referance_number').val(),
                        note: $('#note').val(),
                        invoice_id: $('#invoice_id').val(),
                    },
                    success: function (result) {
                        if (result.errors) {
                            $('#btn_loader').addClass('hide');
                            $("button[name='judge_type_btn']").removeAttr("disabled", "disabled");
                            $('.alert-danger').html('');
                        } else {
                            $('.alert-danger').hide();
                            $('#clientPaymentreceivemodal').modal('hide');
                            location.reload();
                            // success_massage('Payment save successfully.');
                            message.fire({
                                type: 'success',
                                title: 'Success',
                                text: 'Payment save successfully.',
                            });


                            //  var d = $('#clientAccountlistDatatable').DataTable();
                            // d.ajax().reload();

                        }
                    }
                });

            }
        })

    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    $('#method').on('change', function () {
        var getVal = this.value;
        if (getVal == 'Cash' || getVal == '') {
            $("#show_cheque_date").addClass('hide');
            $("#show_star").addClass('hide');
        } else if (getVal == 'Cheque') {
            $("#show_cheque_date").removeClass('hide');
            $("#show_star").removeClass('hide');
        } else {
            $("#show_cheque_date").addClass('hide');
            $("#show_star").removeClass('hide');
        }
    });

    $('.date1').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
    });
    $('#cheque_date').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
    });

});






