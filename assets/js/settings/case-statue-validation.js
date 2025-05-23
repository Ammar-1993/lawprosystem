"use strict";

// التحقق من وجود كائنات الترجمة في الأعلى
if (typeof caseStatusValidationMessages === 'undefined') {
    console.error('caseStatusValidationMessages object not found. Ensure it is injected in Blade before this script.');
    var caseStatusValidationMessages = { case_status: {} }; // كائن احتياطي فارغ
}
if (typeof commonJsLang === 'undefined') {
    console.error('commonJsLang object not found. Ensure it is injected in Blade before this script.');
    var commonJsLang = { success_title: 'Success', error_title: 'Error', generic_error: 'Something went wrong!' }; // كائن احتياطي بسيط
}

var token = $('#token-value').val();
var common_check_exist = $('#common_check_exist').val();

// يمكن إعادة تسمية FormControlsClient إلى FormControlsCaseStatus للوضوح
var FormControlsCaseStatus = {

    init: function () {
        var btn = $("form :submit");
        $("#tagForm").validate({ // اسم النموذج tagForm
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                case_status: { // اسم الحقل في النموذج
                    required: true,
                    remote: {
                        async: false,
                        url: common_check_exist,
                        type: "post",
                        data: {
                            _token: function () {
                                return token;
                            },
                            form_field: function () {
                                return $("#case_status").val(); // اسم حقل الإدخال
                            },
                            id: function () {
                                // إذا كان هذا النموذج يستخدم للتعديل أيضاً ولديك حقل ID مخفي، استخدمه هنا
                                // return $("#id").val();
                                return ''; // للإضافة فقط، أو إذا لم يكن حقل ID موجودًا
                            },
                            db_field: function () { // اسم العمود في قاعدة البيانات
                                return 'case_status_name';
                            },
                            table: function () { // اسم الجدول
                                return 'case_statuses';
                            },
                            condition_form_field: function () {
                                return '';
                            },
                            condition_db_field: function () {
                                return '';
                            }
                        }
                    }
                }
            },
            messages: {
                case_status: {
                    required: (caseStatusValidationMessages.case_status && caseStatusValidationMessages.case_status.required) ? caseStatusValidationMessages.case_status.required : "Case Status is required",
                    remote: (caseStatusValidationMessages.case_status && caseStatusValidationMessages.case_status.remote) ? caseStatusValidationMessages.case_status.remote : "Case status already exists." // تم تصحيح exits
                }
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (form) { // تم تغيير المتغير إلى form
                $("#cl").removeClass('ik ik-check-circle').addClass('fa fa-spinner fa-spin');
                $(form).find("button[type='submit']").attr("disabled", "disabled");

                var formData = new FormData(form); // استخدام 'form' مباشرة
                var url = $(form).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (data) {
                        $("#addtag").modal('hide');
                        // تأكد من أن tagDataTable هو الاسم الصحيح لجدول البيانات الخاص بحالات القضايا
                        if ($.fn.DataTable.isDataTable("#tagDataTable")) {
                             $("#tagDataTable").dataTable().api().ajax.reload(null, false);
                        }
                        message.fire({
                            type: 'success',
                            title: commonJsLang.success_title || 'Success',
                            text: data.message, // رسالة النجاح من الخادم
                        });
                        $(form)[0].reset(); // إعادة تعيين النموذج بعد النجاح
                        $('#form-errors').html(''); // مسح أي أخطاء سابقة من الخادم
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorsHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            errorsHtml += '</ul></div>'; // تم تصحيح إغلاق الـ div
                            $('#form-errors').html(errorsHtml);
                        } else {
                            $('#form-errors').html('');
                            message.fire({
                                type: 'error',
                                title: commonJsLang.error_title || 'Error',
                                text: commonJsLang.generic_error || 'something went wrong please try again !',
                            });
                        }
                    },
                    complete: function() {
                        $("#cl").removeClass('fa fa-spinner fa-spin').addClass('ik ik-check-circle');
                        $(form).find("button[type='submit']").removeAttr("disabled");
                    }
                });
            }
        })
    }
};

jQuery(document).ready(function () {
    if (typeof FormControlsCaseStatus !== 'undefined') { // أو FormControlsClient إذا لم تقم بإعادة التسمية
        FormControlsCaseStatus.init();
    }

    // الكود الخاص بـ Select2 في نهاية الملف الأصلي كان يستهدف ".case_type"
    // هذا النموذج لا يحتوي على حقل بهذا الكلاس، لذلك تم إبقاؤه مُعلقًا أو يمكن إزالته
    // $(".case_type").select2({
    //     allowClear: true,
    //     placeholder: 'Select Court' // يمكن ترجمة هذا أيضاً إذا كان مستخدماً
    // });

    // مسح النموذج عند إغلاق المودال (اختياري)
    $('#addtag').on('hidden.bs.modal', function () {
        $("#tagForm")[0].reset();
        $("#tagForm").validate().resetForm(); // إزالة رسائل الخطأ الخاصة بـ jQuery Validate
        $('#form-errors').html(''); // مسح رسائل الخطأ من الخادم
    });
});