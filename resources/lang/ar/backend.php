<?php

return [



    'case_status_validation' => [
        'case_status' => [ // يطابق اسم الحقل في النموذج
            'required' => 'اسم حالة القضية مطلوب.',
            'remote'   => 'حالة القضية هذه موجودة بالفعل.',
        ],
    ],







    'tax_validation' => [
        'name' => [
            'required' => 'اسم الضريبة مطلوب.',
        ],
        'per' => [ // 'per' تشير إلى النسبة المئوية
            'required' => 'نسبة الضريبة مطلوبة.',
            'remote'   => 'مزيج اسم ونسبة الضريبة هذا موجود بالفعل.', // رسالة للتحقق من عدم التكرار
        ],
    ],





    'profile_page_validations' => [ // اسم المفتاح الجديد لمجموعة الترجمات
        'f_name' => 'يرجى إدخال الاسم الأول.',
        'l_name' => 'يرجى إدخال اسم العائلة.',
        'mobile' => [
            'required' => 'يرجى إدخال رقم هاتفك المحمول.',
            'minlength' => 'يجب أن يتكون رقم الهاتف المحمول من 10 أرقام بالضبط.',
            'maxlength' => 'يجب أن يتكون رقم الهاتف المحمول من 10 أرقام بالضبط.',
            'number' => 'يرجى إدخال رقم هاتف محمول صالح مكون من 10 أرقام (0-9).'
        ],
        'address' => 'يرجى إدخال عنوانك.',
        'zip_code' => [
            'required' => 'يرجى إدخال الرمز البريدي.',
            'minlength' => 'يجب أن يتكون الرمز البريدي من 6 أرقام بالضبط.',
            'maxlength' => 'يجب أن يتكون الرمز البريدي من 6 أرقام بالضبط.',
            'number' => 'يرجى إدخال رمز بريدي صالح مكون من 6 أرقام (0-9).'
        ],
        'country' => 'يرجى تحديد بلدك.',
        'registration_no' => 'يرجى إدخال رقم التسجيل.',
        'associated_name' => 'يرجى إدخال الاسم المرتبط.',
        'state' => 'يرجى تحديد ولايتك/منطقتك.',
        'city_id' => 'يرجى تحديد مدينتك.',
        'email' => [
            'required' => 'يرجى إدخال عنوان بريدك الإلكتروني.',
            'email' => 'يرجى إدخال عنوان بريد إلكتروني صالح.',
            'remote' => 'عنوان البريد الإلكتروني هذا مسجل بالفعل.'
        ]
    ],

    'change_password' => [
        // رسائل التحقق من صحة نموذج تغيير كلمة المرور
        'validation_old_required'       => 'يرجى إدخال كلمة المرور الحالية',
        'validation_new_required'       => 'يرجى إدخال كلمة مرور جديدة',
        'validation_new_pwcheck'        => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل وأن تشتمل على حرف كبير وحرف صغير ورقم وحرف خاص (#?!@$%^&*-)',
        'validation_new_minlength'      => 'يجب أن تتكون كلمة المرور الجديدة من 8 أحرف على الأقل',
        'validation_confirm_required'   => 'يرجى تأكيد كلمة المرور الجديدة',
        'validation_confirm_minlength'  => 'يجب أن تتكون كلمة مرور التأكيد من 8 أحرف على الأقل',
        'validation_confirm_equalTo'    => 'كلمة مرور التأكيد لا تتطابق مع كلمة المرور الجديدة',
    ],

    // .. maybe other keys ...

    'task' => [
        // Validation Keys
        'subject'              => 'يرجى إدخال موضوع المهمة.',
        'start_date'           => 'يرجى تحديد تاريخ البدء.',
        'end_date'             => 'يرجى تحديد تاريخ الانتهاء.',
        'project_status_id'    => 'يرجى تحديد الحالة.',
        'priority'             => 'يرجى تحديد الأولوية.',
        'assigned_to_required' => 'يرجى تحديد مستخدم واحد على الأقل.',

        // Placeholder Keys
        'ph_search_customer'  => 'ابحث عن عميل', // For #related_id
        'ph_select_status'    => 'اختر الحالة', // For #project_status_id
        'ph_select_priority'  => 'اختر الأولوية', // For #priority
        'ph_select_users'     => 'اختر المستخدمين', // For #assigned_to
        'ph_nothing_selected' => 'لم يتم تحديد أي شيء', // For #related
    ],

    'party_advocate'      => 'يرجى إدخال اسم المحامي',

    // ... other keys ...

    'case' => [
        'validation' => [
            'client_name'       => 'يرجى إدخال اسم العميل.',
            'party_name'        => 'يرجى إدخال الاسم.', // لـ repeater
            'party_advocate'    => 'يرجى إدخال اسم المحامي.', // لـ repeater
            'case_no'           => 'يرجى إدخال رقم القضية.',
            'case_type'         => 'يرجى تحديد نوع القضية.',
            'case_status'       => 'يرجى تحديد مرحلة القضية.',
            'act'               => 'يرجى إدخال القانون/التشريع.',
            'court_type'        => 'يرجى تحديد نوع المحكمة.',
            'next_date'         => 'يرجى تحديد تاريخ الجلسة الأولى.',
            'court_no'          => 'يرجى إدخال رقم المحكمة.',
            'court_name'        => 'يرجى تحديد المحكمة.', // تم تعديلها لتناسب حقل select
            'judge_type'        => 'يرجى تحديد القاضي.',   // تم تعديلها لتناسب حقل select
            'filing_number'     => 'يرجى إدخال رقم الإيداع.',
            'filing_date'       => 'يرجى تحديد تاريخ الإيداع.',
            'registration_number' => 'يرجى إدخال رقم التسجيل.',
            'registration_date' => 'يرجى تحديد تاريخ التسجيل.',
        ],
        'placeholders' => [
            'select_users'           => 'اختر المستخدمين',
            'select_case_type'       => 'اختر نوع القضية',
            'select_case_sub_type'   => 'اختر النوع الفرعي للقضية',
            'select_stage_of_case'   => 'اختر مرحلة القضية',
            'select_court_type'      => 'اختر نوع المحكمة',
            'select_court'           => 'اختر المحكمة',
            'select_judge_type'      => 'اختر اسم القاضي', // تم تعديلها لتناسب حقل judge_type (select)
            'select_client_name'     => 'اختر اسم العميل',
        ],
        'labels' => [
            'petitioner_name'     => 'اسم المدعي',
            'petitioner_advocate' => 'محامي المدعي',
            'respondent_name'     => 'اسم المدعى عليه',
            'respondent_advocate' => 'محامي المدعى عليه',
        ],
        'confirm' => [
            'delete_element' => 'هل أنت متأكد أنك تريد حذف هذا العنصر؟',
        ],
        'misc' => [
            'loading' => 'جار التحميل...',
        ]
    ],

    // ... maybe other keys ...

    'service' => [
        'name' => [
            'required' => 'الاسم مطلوب',
            'remote' => 'الاسم موجود بالفعل.',
        ],
        'amount' => [
            'required' => 'المبلغ مطلوب',
            'digits' => 'الرجاء إدخال أرقام فقط.',
            'number' => 'يجب أن يكون المبلغ رقمًا.', // If using number rule
        ],
    ],

    'member' => [
        'username' => [
            'required' => 'الرجاء إدخال اسم المستخدم',
            'remote' => 'اسم المستخدم موجود بالفعل',
        ],
        'f_name' => 'الرجاء إدخال الاسم الأول',
        'l_name' => 'الرجاء إدخال الاسم الأخير',
        'email' => [
            'required' => 'الرجاء إدخال البريد الإلكتروني',
            'email' => 'الرجاء إدخال بريد إلكتروني صحيح',
            'remote' => 'البريد الإلكتروني موجود بالفعل',
        ],
        'mobile' => [
            'required' => 'الرجاء إدخال رقم الجوال',
            'minlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'maxlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'number' => 'الرجاء إدخال أرقام من 0 إلى 9',
        ],
        'address' => 'الرجاء إدخال العنوان',
        'zip_code' => [
            'required' => 'الرجاء إدخال الرمز البريدي',
            'minlength' => 'الرمز البريدي يجب أن يتكون من 6 أرقام',
            'maxlength' => 'الرمز البريدي يجب أن يتكون من 6 أرقام',
            'number' => 'الرجاء إدخال أرقام من 0 إلى 9',
        ],
        'password' => [
            'required' => 'الرجاء إدخال كلمة المرور',
            'pwcheck' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل وتحتوي على حرف صغير وحرف كبير ورقم ورمز خاص واحد على الأقل',
            'minlength' => 'الرجاء إدخال 8 أحرف على الأقل',
        ],
        'cnm_password' => [
            'required' => 'الرجاء إدخال تأكيد كلمة المرور',
            'equalTo' => 'الرجاء إدخال نفس كلمة المرور',
        ],
        'country' => 'الرجاء اختيار الدولة',
        'state' => 'الرجاء اختيار المنطقة',
        'city_id' => 'الرجاء اختيار المدينة',
        'role' => 'الرجاء اختيار الدور',
        'select_role_placeholder' => 'اختر الدور',
        'file_size_error' => 'يجب ألا يزيد حجم الملف عن 5 ميغا بايت',
        'file_type_error' => 'الرجاء قبول صور .jpg .png فقط',
    ],

    'appointment' => [
        'mobile' => [
            'required' => 'الرجاء إدخال رقم الجوال',
            'minlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'maxlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'number' => 'الرجاء إدخال أرقام من 0 إلى 9',
        ],
        'date' => 'الرجاء اختيار التاريخ',
        'time' => 'الرجاء إدخال الوقت',
        'new_client' => 'الرجاء إدخال اسم العميل',
        'exists_client' => 'الرجاء اختيار اسم العميل',
    ],

    'client' => [
        'f_name' => 'الرجاء إدخال الاسم الأول',
        'm_name' => 'الرجاء إدخال الاسم الأوسط',
        'l_name' => 'الرجاء إدخال الاسم الأخير',
        // 'email' => 'الرجاء إدخال البريد الإلكتروني',
        'address' => 'الرجاء إدخال العنوان',
        'country' => 'الرجاء اختيار الدولة',
        'state' => 'الرجاء اختيار المنطقة',
        'city_id' => 'الرجاء اختيار المدينة',

        'email' => [
            'required' => 'الرجاء إدخال البريد الإلكتروني',
            'email' => 'الرجاء إدخال بريد إلكتروني صالح',
        ],

        'mobile' => [
            'required' => 'الرجاء إدخال رقم الجوال',
            'minlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'maxlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'number' => 'الرجاء إدخال أرقام من 0 إلى 9',
        ],

        'alternate_no' => [
            'required' => 'الرجاء إدخال رقم بديل',
            'minlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'maxlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'number' => 'الرجاء إدخال أرقام من 0 إلى 9',
        ],

        'reference_mobile' => [
            'required' => 'الرجاء إدخال رقم مرجعي',
            'minlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'maxlength' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'number' => 'الرجاء إدخال أرقام من 0 إلى 9',
        ],

        'are_you_sure_you_want_delete' => 'هل أنت متأكد أنك تريد حذف هذا العنصر؟',

    ],

    'task' => [ // Add this section if it's missing
        'subject' => 'الرجاء إدخال الموضوع',
        'start_date' => 'الرجاء إدخال تاريخ البدء',
        'end_date' => 'الرجاء إدخال الموعد النهائي',
        'project_status_id' => 'الرجاء اختيار الحالة',
        'priority' => 'الرجاء اختيار الأولوية',
        'assigned_to_required' => 'الرجاء اختيار اسم الموظف', // Key for the assigned_to[] rule
    ],


    // ... other keys like client, task, datatable ...



    'common_js' => [
        'success_title' => 'نجاح',
        'error_title' => 'خطأ',

        'generic_error' => 'حدث خطأ ما، يرجى المحاولة مرة أخرى',
        'confirm_title' => 'هل أنت متأكد؟',
        'confirm_text' => 'لن تتمكن من التراجع عن هذا',
        'confirm_button' => 'نعم، احذفه',
        'cancel_button' => 'لا، إلغاء',
        'validation_phone' => 'الرجاء إدخال رقم هاتف صحيح',
        'validation_filesize' => 'يجب أن يكون حجم الملف أقل من 5 ميغا بايت',
        'validation_required' => 'هذا الحقل مطلوب',
        'loading' => 'تحميل...',



        'dt_empty_table' => 'لا توجد بيانات متاحة في الجدول',
        'dt_info' => 'عرض _START_ إلى _END_ من إجمالي _TOTAL_ مدخل',
        'dt_info_empty' => 'عرض 0 إلى 0 من إجمالي 0 مدخل',
        'dt_info_filtered' => '(تمت تصفيتهم من إجمالي _MAX_ مدخل)',
        'dt_length_menu' => 'إظهار _MENU_ مدخلات',
        'dt_loading_records' => 'تحميل...',
        'dt_processing' => 'معالجة...',
        'dt_search' => 'بحث:',
        'dt_zero_records' => 'لم يتم العثور على سجلات مطابقة',
        'dt_first' => 'الأول',
        'dt_next' => 'التالي',
        'dt_previous' => 'السابق',
        'dt_last' => 'الأخير',
        'dt_sort_ascending' => ': تفعيل لترتيب العمود تصاعدياً',
        'dt_sort_descending' => ': تفعيل لترتيب العمود تنازلياً',


    ],


    'tax_updated_successfully' => 'تم تحديث الضريبة بنجاح',
    'tax_added_successfully' => 'تم إضافة الضريبة بنجاح',
    'tax_status_changed_successfully' => 'تم تغيير حالة الضريبة بنجاح',
    'tax_deleted_successfully' => 'تم حذف الضريبة بنجاح',
    'success_title' => 'نجاح',
    'you_cant_delete_tax_because' => 'لا يمكنك حذف الضريبة لأنها مستخدمة في وحدة أخرى',
    'save_successfully' => 'تم الحفظ بنجاح',
    'appointment_added_successfully' => 'تمت إضافة الموعد بنجاح',
    'appointment_updated_successfully' => 'تم تحديث الموعد بنجاح',

    'case_added_successfully' => 'تمت إضافة القضية بنجاح',
    'case_updated_successfully' => 'تم تحديث القضية بنجاح',
    'case_status_added_successfully' => 'تمت إضافة حالة القضية بنجاح',
    'case_status_updated_successfully' => 'تم تحديث حالة القضية بنجاح',
    'case_status_changed_successfully' => 'تم تغيير حالة القضية بنجاح',
    'case_status_deleted_successfully' => 'تم حذف حالة القضية بنجاح',
    'cannot_delete_case_status_used' => 'لا يمكنك حذف حالة القضية لأنها مستخدمة في وحدة أخرى',
    'case_type_added_successfully' => 'تمت إضافة نوع القضية بنجاح',
    'case_type_edited_successfully' => 'تم تعديل نوع الحالة بنجاح',
    'case_type_status_changed_successfully' => 'تم تغيير حالة نوع القضية بنجاح',
    'case_type_deleted_successfully' => 'تم حذف نوع القضية بنجاح',
    'cannot_delete_case_type_used' => 'لا يمكنك حذف نوع القضية لأنه مستخدم في وحدة أخرى',
    'client_added_successfully' => 'تمت إضافة العميل بنجاح',
    'client_updated_successfully' => 'تم تحديث العميل بنجاح',
    'client_deleted_successfully' => 'تم حذف العميل بنجاح',
    'team_member_created_successfully' => 'تم إنشاء عضو الفريق بنجاح',
    'account_setup_successfully' => 'تم إعداد الحساب بنجاح',
    'team_member_updated_successfully' => 'تم تحديث عضو الفريق بنجاح',
    'cannot_delete_team_member_used' => 'لا يمكنك حذف عضو الفريق هذا لأنه مستخدم في وحدات أخرى',
    'team_member_deleted_successfully' => 'تم حذف عضو الفريق بنجاح',
    'court_added_successfully' => 'تمت إضافة المحكمة بنجاح',
    'court_updated_successfully' => 'تم تحديث المحكمة بنجاح',
    'court_status_changed_successfully' => 'تم تغيير حالة المحكمة بنجاح',
    'court_deleted_successfully' => 'تم حذف المحكمة بنجاح',
    'cannot_delete_court_used' => 'لا يمكنك حذف المحكمة لأنها مستخدمة في وحدة أخرى',
    'backup_restored_successfully' => 'تم استعادة النسخة الاحتياطية بنجاح',
    'expense_added_successfully' => 'تمت إضافة النفقات بنجاح',
    'expense_updated_successfully' => 'تم تحديث النفقات بنجاح',
    'expense_deleted_successfully' => 'تم حذف النفقات بنجاح',
    'expense_type_added_successfully' => 'تمت إضافة نوع النفقات بنجاح',
    'expense_type_updated_successfully' => 'تم تحديث نوع النفقات بنجاح',
    'expense_type_status_changed_successfully' => 'تم تغيير حالة نوع النفقات بنجاح',
    'expense_type_deleted_successfully' => 'تم حذف نوع النفقات بنجاح',
    'database_backup_saved_successfully' => 'تم حفظ النسخة الاحتياطية لقاعدة البيانات بنجاح',
    'saved_successfully' => 'تم الحفظ بنجاح',
    'invoice_sent_successfully' => 'تم إرسال الفاتورة بنجاح في البريد الإلكتروني',
    'smtp_not_set_error' => 'يرجى أولاً تعيين تفاصيل SMTP في الإعدادات',
    'invoice_generated_successfully' => 'تم إنشاء الفاتورة بنجاح',
    'invoice_updated_successfully' => 'تم تحديث الفاتورة بنجاح',
    'invoice_deleted_successfully' => 'تم حذف الفاتورة بنجاح',
    'settings_saved_successfully' => 'تم حفظ الإعدادات بنجاح',
    'judge_added_successfully' => 'تمت إضافة القاضي بنجاح',
    'judge_updated_successfully' => 'تم تحديث القاضي بنجاح',
    'judge_status_changed_successfully' => 'تم تغيير حالة القاضي بنجاح',
    'judge_deleted_successfully' => 'تم حذف القاضي بنجاح',
    'cannot_delete_tax_used' => 'لا يمكنك حذف الضريبة لأنها مستخدمة في وحدة أخرى',
    'permissions_updated_successfully' => 'تم تحديث الأذونات بنجاح',
    'password_changed_successfully' => 'تم تغيير كلمة المرور بنجاح',
    'unable_to_process_request_this_time' => 'تعذرت معالجة الطلب هذه المرة. حاول مرة أخرى لاحقًا',
    'current_password_do_not_match' => 'كلمة المرور الحالية لا تتطابق',
    'profile_updated_successfully' => 'تم تحديث الملف الشخصي بنجاح',
    'role_created_successfully' => 'تم إنشاء الدور بنجاح',
    'role_updated_successfully' => 'تم تحديث الدور بنجاح',
    'role_deleted_successfully' => 'تم حذف الدور بنجاح',
    'service_created_successfully' => 'تم إنشاء الخدمة بنجاح',
    'service_updated_successfully' => 'تم تحديث الخدمة بنجاح',
    'service_deleted_successfully' => 'تم حذف الخدمة بنجاح',
    'cannot_delete_service_used' => 'لا يمكنك حذف الخدمة لأنها مستخدمة في وحدة أخرى',
    'service_status_changed_successfully' => 'تم تغيير حالة الخدمة بنجاح',
    'task_created_successfully' => 'تم إنشاء المهمة بنجاح',
    'task_updated_successfully' => 'تم تحديث المهمة بنجاح',
    'task_deleted_successfully' => 'تم حذف المهمة بنجاح',
    'vendor_added_successfully' => 'تمت إضافة المالية بنجاح',
    'vendor_updated_successfully' => 'تم تحديث المالية بنجاح',
    'vendor_deleted_successfully' => 'تم حذف المالية بنجاح',

    'cannot_delete_role_has_permissions' => 'لا يمكن حذف الدور الذي له صلاحيات معينة. يرجى إزالة الصلاحيات أولاً', // Translation for reworded message
    'cannot_delete_vendor_used' => 'لا يمكنك حذف المالية لأنه مستخدم في وحدة أخرى',
    'cannot_delete_client_used' => 'العميل مستخدم في وحدة أخرى لذا لا يمكنك حذفه',
    'cannot_delete_case_type_used' => 'لا يمكنك حذف نوع القضية لأنه مستخدم في وحدة أخرى', // Handled duplicate
    'cannot_delete_court_type_used' => 'لا يمكنك حذف نوع المحكمة لأنه مستخدم في وحدة أخرى', // Handled duplicate
    'court_type_deleted_successfully' => 'تم حذف نوع المحكمة بنجاح', // Handled duplicate
    'court_type_status_changed_successfully' => 'تم تغيير حالة نوع المحكمة بنجاح', // Handled duplicate
    'court_type_updated_successfully' => 'تم تحديث نوع المحكمة بنجاح',
    'court_type_added_successfully' => 'تمت إضافة نوع المحكمة بنجاح',


];
