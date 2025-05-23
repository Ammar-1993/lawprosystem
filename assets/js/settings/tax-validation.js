"use strict";

// التحقق من وجود كائنات الترجمة في الأعلى
if (typeof taxValidationMessages === 'undefined') {
    console.error('taxValidationMessages object not found. Ensure it is injected in Blade before this script.');
    var taxValidationMessages = { name: {}, per: {} }; // كائن احتياطي فارغ
}
if (typeof commonJsLang === 'undefined') {
    console.error('commonJsLang object not found. Ensure it is injected in Blade before this script.');
    var commonJsLang = { success_title: 'Success', error_title: 'Error', generic_error: 'Something went wrong!' }; // كائن احتياطي بسيط
}

var token = $("#token-value").val();
var common_check_exist = $("#common_check_exist").val();

// يمكن إعادة تسمية FormControlsClient إلى FormControlsTax للوضوح
var FormControlsTax = {
    init: function () {
        var btn = $("form :submit");
        $("#tagForm").validate({ // اسم النموذج tagForm
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                per: { // حقل النسبة المئوية
                    required: true,
                    number: true, // من الأفضل إضافة قاعدة للتحقق من أن المدخل رقم
                    remote: {
                        async: false,
                        url: common_check_exist,
                        type: "post",
                        data: {
                            _token: function () {
                                return token;
                            },
                            form_field: function () { // القيمة التي يتم فحصها في قاعدة البيانات مع النسبة
                                return $("#name").val();
                            },
                            id: function () {
                                // إذا كان هذا النموذج يستخدم للتعديل أيضاً ولديك حقل ID مخفي
                                // return $("#id").val();
                                return ''; // للإضافة فقط، أو إذا لم يكن حقل ID موجودًا
                            },
                            db_field: function () { // اسم العمود للاسم في قاعدة البيانات
                                return "name";
                            },
                            table: function () { // اسم الجدول
                                return "all_taxes";
                            },
                            condition_form_field: function () { // قيمة النسبة المئوية
                                return $("#per").val();
                            },
                            condition_db_field: function () { // اسم عمود النسبة في قاعدة البيانات
                                return "per";
                            },
                        },
                    },
                },
                name: { // حقل الاسم
                    required: true,
                    // يمكن إضافة remote check للاسم فقط إذا أردت، ولكن الـ remote الحالي على 'per' يفحص الاثنين معاً
                },
            },
            messages: {
                per: {
                    required: (taxValidationMessages.per && taxValidationMessages.per.required) ? taxValidationMessages.per.required : "Tax rate is required.",
                    number: (taxValidationMessages.per && taxValidationMessages.per.number) ? taxValidationMessages.per.number : "Please enter a valid number for tax rate.", // رسالة لقاعدة number
                    remote: (taxValidationMessages.per && taxValidationMessages.per.remote) ? taxValidationMessages.per.remote : "This tax name and rate combination already exists." // تم تصحيح exits إلى exists
                },
                name: {
                    required: (taxValidationMessages.name && taxValidationMessages.name.required) ? taxValidationMessages.name.required : "Name is required.",
                },
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass("text-danger");
            },
            submitHandler: function (form) { // تم تغيير المتغير إلى form
                $("#cl")
                    .removeClass("ik ik-check-circle")
                    .addClass("fa fa-spinner fa-spin");
                
                $(form).find("button[type='submit']").attr("disabled", "disabled"); // تعطيل زر الإرسال

                var formData = new FormData(form); // استخدام 'form' مباشرة
                var url = $(form).attr("action");

                $.ajax({
                    url: url,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (data) {
                        $("#addtag").modal("hide");
                        // تأكد من أن tagDataTable هو الاسم الصحيح لجدول البيانات الخاص بالضرائب
                        if ($.fn.DataTable.isDataTable("#tagDataTable")) {
                             $("#tagDataTable").dataTable().api().ajax.reload(null, false);
                        }
                        message.fire({
                            type: "success",
                            title: commonJsLang.success_title || "Success",
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
                                errorsHtml += "<li>" + value[0] + "</li>";
                            });
                            errorsHtml += "</ul></div>"; // تم تصحيح إغلاق الـ div
                            $("#form-errors").html(errorsHtml);
                        } else {
                             $("#form-errors").html(''); // مسح الأخطاء إذا لم يكن خطأ تحقق 422
                             message.fire({
                                type: "error",
                                title: commonJsLang.error_title || "Error",
                                text: commonJsLang.generic_error || "Something went wrong, please try again!",
                            });
                        }
                    },
                    complete: function() { // يتم تنفيذه دائماً بعد success أو error
                        $("#cl")
                            .removeClass("fa fa-spinner fa-spin")
                            .addClass("ik ik-check-circle");
                        $(form).find("button[type='submit']").removeAttr("disabled"); // إعادة تمكين زر الإرسال
                    }
                });
            },
        });
    },
};

jQuery(document).ready(function () {
    if (typeof FormControlsTax !== 'undefined') { // Or FormControlsClient if you didn't rename
        FormControlsTax.init();
    }

    // إذا كان لديك select2 لـ .case_type كما في نهاية الملف الأصلي، تأكد من ترجمة الـ placeholder
    // المثال الحالي لا يحتوي على حقل select بهذا الكلاس في HTML
    // $(".case_type").select2({
    //     allowClear: true,
    //     placeholder: "Select Tax", // يمكن ترجمة هذا أيضاً إذا كان مستخدماً
    // });

    // مسح النموذج عند إغلاق المودال (اختياري)
    $('#addtag').on('hidden.bs.modal', function () {
        $("#tagForm")[0].reset();
        $("#tagForm").validate().resetForm(); // إزالة رسائل الخطأ الخاصة بـ jQuery Validate
        $('#form-errors').html(''); // مسح رسائل الخطأ من الخادم
    });
});