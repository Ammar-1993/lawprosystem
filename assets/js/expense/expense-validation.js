"use strict";
var token = $('#token-value').val();
var common_check_exist = $('#common_check_exist').val();
var expense_create = $('#expense_create').val();
var getVendorDetailById = $('#getVendorDetailById').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_expense").validate({
            errorContainer: "contactAlert",
            errorLabelContainer: "#contactAlert div",
            wrapper: "div",
            rules: {
                vendor_id: "required",
                inv_no: "required",
                due_Date: "required",
                inv_date: "required",
            },
            messages: {
                vendor_id: "Please select vendor.",
                inv_no: "Bill no is required",
                due_Date: "Please select date.",
                inv_date: "Please select date.",
            }, errorPlacement: function () {

                if ($('#vendor_id').val() == "") {
                    $("#vendor_id").closest('.form-group').addClass('has-error');
                } else {
                    $("#vendor_id").closest('.form-group').removeClass('has-error');
                }

                $('.categories_ids').each(function () {

                    if ($(this).val() == "") {
                        $(this).closest('.text-center').addClass('has-error');
                    } else {
                        $(this).closest('.text-center').removeClass('has-error');
                    }
                });
                return false;
            },
            submitHandler: function () {

                // $('#show_loader1').removeClass('fa-save');
                // $('#show_loader1').addClass('fa-spin fa-spinner');
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $('.dropdown-toggle').removeAttr('data-toggle');
                $("button[name='btn_add_appointment']").attr("disabled", "disabled").button('refresh');
                return true;
            }

        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    $(".case_type").select2({
        allowClear: true,
        placeholder: 'Select Case Type'
    });


    //rate and qty key up event
    $(document).on('keyup', '.qty , .rate', function () {

        var qty = $(this).closest('tr').find('input.qty').val();
        var rate = $(this).closest('tr').find('input.rate').val();
        var price = calculatePrice(qty, rate);

        $(this).closest('tr').find('input.amount').val(price.toFixed(2));
        var subTotal = calculateSubTotal();
        $("#subTotal").val(subTotal.toFixed(2));

        //for tax
        var tax = $('#tax').find('option:selected');
        var myTax = tax.attr("myTax");

        if (myTax != "") {
            var g = caculateTax(myTax, subTotal);
            $("#taxVal").val(parseFloat(g).toFixed(2));
            g = roundToTwo(parseFloat(g) + parseFloat(subTotal));

            $("#grandTotal").val(g.toFixed(2));
        } else {
            $("#taxVal").val("0.00");
            $("#grandTotal").val(subTotal.toFixed(2));
        }

    });

    $(document).on('keyup', '.rate', function () {

        this.value = this.value
            .replace(/[^\d.]/g, '')             // numbers and decimals only
            .replace(/(^[\d]{10})[\d]/g, '$1')   // not more than 2 digits at the beginning
            .replace(/(\..*)\./g, '$1')         // decimal can't exist more than once
            .replace(/(\.[\d]{2})./g, '$1');    // not more than 4 digits after decimal

    });

    $('.tax').on('change', function () {

        var tax = $('#tax').find('option:selected');
        var myTax = tax.attr("myTax");
        var subTotal = calculateSubTotal();
        // alert( myTax);
        $("#subTotal").val(subTotal.toFixed(2));

        if (myTax != "") {
            var g = caculateTax(myTax, subTotal);
            $("#taxVal").val(parseFloat(g).toFixed(2));
            g = roundToTwo(parseFloat(g) + parseFloat(subTotal));


            $("#grandTotal").val(g.toFixed(2));
        } else {
            $("#taxVal").val("0.00");
            $("#grandTotal").val(subTotal.toFixed(2));
        }

    });


    $(".inc_Date").datepicker({
        format: date_format_datepiker,
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('.due_Date').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('.due_Date').datepicker('setStartDate', null);
    });

    $(".due_Date").datepicker({
        format: date_format_datepiker,
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('.inc_Date').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('.inc_Date').datepicker('setEndDate', null);
    });


    // $('.select2-container').remove();
    $(".select2").select2({
        allowClear: true,
        placeholder: 'Select Client'
    });


    $("#tax").select2({
        allowClear: true,
        width: '100%',
        placeholder: 'Select Tax'
    });


    $('.repeater').repeater({
        // (Optional)
        // start with an empty list of repeaters. Set your first (and only)
        // "data-repeater-item" with style="display:none;" and pass the
        // following configuration flag
        initEmpty: false,
        // (Optional)
        // "defaultValues" sets the values of added items.  The keys of
        // defaultValues refer to the value of the input's name attribute.
        // If a default value is not specified for an input, then it will
        // have its value cleared.
        defaultValues: {
            'text-input': 'foo'
        },
        // (Optional)
        // "show" is called just after an item is added.  The item is hidden
        // at this point.  If a show callback is not given the item will
        // have $(this).show() called on it.
        show: function () {
            // $('.select2-container').remove();
            $('.sel').select2({
                placeholder: "Select Item",
                allowClear: true
            });
            $('.select2-container').css('width', '100%');
            $(this).slideDown();


        },
        // (Optional)
        // "hide" is called when a user clicks on a data-repeater-delete
        // element.  The item is still visible.  "hide" is passed a function
        // as its first argument which will properly remove the item.
        // "hide" allows for a confirmation step, to send a delete request
        // to the server, etc.  If a hide callback is not given the item
        // will be deleted.
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }


        },
        // (Optional)
        // You can use this if you need to manually re-index the list
        // for example if you are using a drag and drop library to reorder
        // list items.
        ready: function (setIndexes) {
            //$dragAndDrop.on('drop', setIndexes);
            // $('.select2-container').remove();
            $('.sel').select2({
                placeholder: "Select Item",
                allowClear: true
            });
            $('.select2-container').css('width', '100%');
        },
        // (Optional)
        // Removes the delete button from the first list item,
        // defaults to false.
        isFirstItemUndeletable: true
    })


});


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isFloatsNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function doReload(catid) {
    if (catid) {
        var base_url = expense_create + catid;
        document.location = base_url;

    } else {

        var base_url = expense_create;
        document.location = base_url;

    }
}


function calculatePrice(qty, rate) {

    var price = (qty * rate);
    return roundToTwo(price);
}


function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}

function calculateSubTotal() {
    var subTotal = 0;
    $('.amount').each(function () {

        if ($(this).val()) {
            subTotal += parseFloat($(this).val());
        }
    });
    return roundToTwo(subTotal);
}

// calculate tax
function caculateTax(p, t) {
    var tax = (p * t) / 100;
    return roundToTwo(tax);
}

//city state counter dependancy
function getVendorBillingAddress(id) {


    if (id != '') {
        ajaxindicatorstart('Please wait a moment..');
        $('.show_vendor_detail').html('Loading Detail...');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: getVendorDetailById,
            method: "POST",
            data: {
                id: id
            },
            success: function (result) {
                ajaxindicatorstop();
                if (result.errors) {
                    $('.alert-danger').html('');
                } else {
                    $('.show_vendor_detail').html(result);
                }
            }
        });
    } else {
        $('.show_vendor_detail').empty();
    }
}
