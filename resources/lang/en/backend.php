<?php

return [




    'case_status_validation' => [
        'case_status' => [ // Matches the field name in the form
            'required' => 'Case status name is required.',
            'remote'   => 'This case status already exists.',
        ],
    ],










    'tax_validation' => [
        'name' => [
            'required' => 'Tax name is required.',
        ],
        'per' => [ // 'per' for percentage/rate
            'required' => 'Tax rate is required.',
            'remote'   => 'This tax name and rate combination already exists.',
        ],
    ],



    'profile_page_validations' => [ // The new key for this group of translations
        'f_name' => 'Please enter your first name.',
        'l_name' => 'Please enter your last name.',
        'mobile' => [
            'required' => 'Please enter your mobile number.',
            'minlength' => 'Mobile number must be exactly 10 digits.',
            'maxlength' => 'Mobile number must be exactly 10 digits.',
            'number' => 'Please enter a valid 10-digit mobile number (0-9).'
        ],
        'address' => 'Please enter your address.',
        'zip_code' => [
            'required' => 'Please enter your zip code.',
            'minlength' => 'Zip code must be exactly 6 digits.',
            'maxlength' => 'Zip code must be exactly 6 digits.',
            'number' => 'Please enter a valid 6-digit zip code (0-9).'
        ],
        'country' => 'Please select your country.',
        'registration_no' => 'Please enter registration number.',
        'associated_name' => 'Please enter associated name.',
        'state' => 'Please select your state.',
        'city_id' => 'Please select your city.',
        'email' => [
            'required' => 'Please enter your email address.',
            'email' => 'Please enter a valid email address.',
            'remote' => 'This email address is already registered.'
        ]
    ],



    'change_password' => [
        // Validation Messages for change password form
        'validation_old_required'       => 'Please enter the current password.',
        'validation_new_required'       => 'Please enter a new password.',
        'validation_new_pwcheck'        => 'Password must be at least 8 characters and include uppercase, lowercase, number, and special character (#?!@$%^&*-).',
        'validation_new_minlength'      => 'New password must be at least 8 characters long.',
        'validation_confirm_required'   => 'Please confirm the new password.',
        'validation_confirm_minlength'  => 'Confirm password must be at least 8 characters long.',
        'validation_confirm_equalTo'    => 'The confirmation password does not match the new password.',
    ],

    // ... maybe other keys ...

    'task' => [
        // Validation Keys (will become taskValidationMessages.key in JS)
        'subject'              => 'Please enter task subject.',
        'start_date'           => 'Please select start date.',
        'end_date'             => 'Please select end date.',
        'project_status_id'    => 'Please select status.',
        'priority'             => 'Please select priority.',
        'assigned_to_required' => 'Please select at least one user.', // For "assigned_to[]" required rule

        // Placeholder Keys (we'll access these as taskValidationMessages.ph_key in JS)
        'ph_search_customer'  => 'Search customer', // For #related_id
        'ph_select_status'    => 'Select status', // For #project_status_id
        'ph_select_priority'  => 'Select priority', // For #priority
        'ph_select_users'     => 'Select Users', // For #assigned_to
        'ph_nothing_selected' => 'Nothing selected', // For #related
    ],

    // ... maybe other keys ...

    'party_advocate1'      => 'Please enter advocate name.',

    // ... other keys like 'client', 'task', 'datatable', 'common_js', 'appointment' ...


    'case' => [
        'validation' => [
            'client_name'       => 'Please select a client name.', // Changed for select field
            'party_name'        => 'Please enter the party name.', // For repeater
            'party_advocate'    => 'Please enter the party advocate name.', // For repeater
            'case_no'           => 'Please enter the case number.',
            'case_type'         => 'Please select a case type.',
            'case_status'       => 'Please select the stage of the case.',
            'act'               => 'Please enter the act.',
            'court_type'        => 'Please select a court type.',
            'next_date'         => 'Please select the first hearing date.',
            'court_no'          => 'Please enter the court number.',
            'court_name'        => 'Please select a court.', // Changed for select field
            'judge_type'        => 'Please select a judge.',   // Changed for select field (referring to judge selection)
            'filing_number'     => 'Please enter the filing number.',
            'filing_date'       => 'Please select the filing date.',
            'registration_number' => 'Please enter the registration number.',
            'registration_date' => 'Please select the registration date.',
        ],
        'placeholders' => [
            'select_users'           => 'Select Users',
            'select_case_type'       => 'Select Case Type',
            'select_case_sub_type'   => 'Select Case Sub Type',
            'select_stage_of_case'   => 'Select Stage of Case',
            'select_court_type'      => 'Select Court Type',
            'select_court'           => 'Select Court',
            'select_judge_type'      => 'Select Judge Name', // Placeholder for the judge dropdown
            'select_client_name'     => 'Select Client Name',
        ],
        'labels' => [
            'petitioner_name'     => 'Petitioner Name',
            'petitioner_advocate' => 'Petitioner Advocate',
            'respondent_name'     => 'Respondent Name',
            'respondent_advocate' => 'Respondent Advocate',
        ],
        'confirm' => [
            'delete_element' => 'Are you sure you want to delete this element?',
        ],
        'misc' => [
            'loading' => 'Loading...',
        ]
    ],

    // ... other existing English translations ...


    // ... maybe other keys ...

    'service' => [
        'name' => [
            'required' => 'Name is required',
            'remote' => 'Name already exists.', // Corrected typo
        ],
        'amount' => [
            'required' => 'Amount is required',
            'digits' => 'Allow only digits.', // Use 'digits' key to match rule name if using jQuery default digits rule, or 'number' if rule is 'number:true'
            'number' => 'Amount must be a number.', // Add if using 'number: true' rule instead of 'digits'
        ],
    ],

    'member' => [
        // Note: Assuming 'username' field exists based on messages, though not in rules
        'username' => [
            'required' => 'Please enter username.',
            'remote' => 'Username already exists.', // Corrected spelling
        ],
        'f_name' => 'Please enter first name.', // Corrected example "666"
        'l_name' => 'Please enter last name.',
        'email' => [
            'required' => 'Please enter email.',
            'email' => 'Please enter valid email.',
            'remote' => 'Email already exists.', // Corrected spelling
        ],
        'mobile' => [
            'required' => 'Please enter mobile.',
            'minlength' => 'Mobile must be 10 digit.',
            'maxlength' => 'Mobile must be 10 digit.',
            'number' => 'Please enter digit 0-9.',
        ],
        'address' => 'Please enter address.',
        'zip_code' => [
            'required' => 'Please enter zip code.',
            'minlength' => 'Zip code must be 6 digit.',
            'maxlength' => 'Zip code must be 6 digit.',
            'number' => 'Please enter digit 0-9.',
        ],
        'password' => [
            'required' => 'Please enter password.',
            'pwcheck' => 'Password must be minimum 8 characters and contain at least 1 lowercase, 1 Uppercase, 1 numeric and 1 special character.', // Slightly rephrased
            'minlength' => 'Please enter at least 8 characters.', // Changed 'digit' to 'characters'
        ],
        'cnm_password' => [ // Changed key name slightly for consistency
            'required' => 'Please enter confirm password.',
            'equalTo' => 'Please enter the same password.', // Added message for equalTo
        ],
        'country' => 'Please select country.',
        'state' => 'Please select state.',
        'city_id' => 'Please select city.',
        'role' => 'Please select role.',
        'select_role_placeholder' => 'Select Role', // For Select2 placeholder
        'file_size_error' => 'File size should not be more than 5MB', // For image upload validation
        'file_type_error' => 'Accept only .jpg .png image', // For image upload validation
    ],

    'appointment' => [
        'mobile' => [
            'required' => 'Please enter mobile.',
            'minlength' => 'Mobile must be 10 digit.',
            'maxlength' => 'Mobile must be 10 digit.',
            'number' => 'Please enter digit 0-9.',
        ],
        'date' => 'Please select date.',
        'time' => 'Please enter time.',
        'new_client' => 'Please enter client name.', // For new client input
        'exists_client' => 'Please select client name.', // For existing client dropdown
    ],

    'client' => [
        'f_name' => 'Please enter first name.',
        'm_name' => 'Please enter middle name.',
        'l_name' => 'Please enter last name.',
        // 'email' => 'Please enter email.',
        'address' => 'Please enter address.',
        'country' => 'Please select country.',
        'state' => 'Please select state.',
        'city_id' => 'Please select city.',

        'email' => [
            'required' => 'Please enter email.',
            'email' => 'Please enter a valid email.',
        ],

        'mobile' => [
            'required' => 'Please enter mobile.',
            'minlength' => 'Mobile must be 10 digit.',
            'maxlength' => 'Mobile must be 10 digit.',
            'number' => 'please enter digit 0-9.',
        ],

        'alternate_no' => [
            'required' => 'Please enter alternate no.',
            'minlength' => 'Mobile must be 10 digit.',
            'maxlength' => 'Mobile must be 10 digit.',
            'number' => 'please enter digit 0-9.',
        ],

        'reference_mobile' => [
            'required' => 'Please enter Reference mobile no.',
            'minlength' => 'Mobile must be 10 digit.',
            'maxlength' => 'Mobile must be 10 digit.',
            'number' => 'Please enter digit 0-9.',
        ],

        'are_you_sure_you_want_delete' => 'Are you sure you want to delete this element?'



    ],

    'task' => [ // Add this section if it's missing
        'subject' => 'Please enter subject.',
        'start_date' => 'Please enter start date.',
        'end_date' => 'Please enter deadline.',
        'project_status_id' => 'Please select status.',
        'priority' => 'Please select priority.',
        'assigned_to_required' => 'Please select employee name.', // Key for the assigned_to[] rule
    ],

    // ... other keys like client, task, datatable ...


    'common_js' => [
        'success_title' => 'Success',
        'error_title' => 'Error',

        'generic_error' => 'Something went wrong please try again!',
        'confirm_title' => 'Are you sure?',
        'confirm_text' => "You won't be able to revert this!",
        'confirm_button' => 'Yes, delete it!',
        'cancel_button' => 'No, cancel!',
        'validation_phone' => 'Please enter a valid phone number.',
        'validation_filesize' => 'File size must be less than 5mb.', // Consider if 5mb needs changing or localization
        'validation_required' => 'This field is required.',
        'loading' => 'Loading...', // Added for ajaxindicatorstart text


        'dt_empty_table' => 'No data available in table',
        'dt_info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'dt_info_empty' => 'Showing 0 to 0 of 0 entries',
        'dt_info_filtered' => '(filtered from _MAX_ total entries)',
        'dt_length_menu' => 'Show _MENU_ entries',
        'dt_loading_records' => 'Loading...',
        'dt_processing' => 'Processing...',
        'dt_search' => 'Search:',
        'dt_zero_records' => 'No matching records found',
        'dt_first' => 'First',
        'dt_next' => 'Next',
        'dt_previous' => 'Previous',
        'dt_last' => 'Last',
        'dt_sort_ascending' => ': activate to sort column ascending',
        'dt_sort_descending' => ': activate to sort column descending',



    ],



    'tax_updated_successfully' => 'Tax updated successfully',
    'tax_added_successfully' => 'Tax added successfully',
    'tax_status_changed_successfully' => 'Tax status changed successfully',
    'tax_deleted_successfully' => 'Tax deleted successfully',
    'you_cant_delete_tax_because' => 'You cant delete Tax because it is use in other module',
    'save_successfully' => 'Save Successfully',
    'appointment_added_successfully' => 'Appointment added successfully',
    'appointment_updated_successfully' => 'Appointment updated successfully',
    'success_title' => 'Success',

    'case_added_successfully' => 'Case added successfully',
    'case_updated_successfully' => 'Case updated successfully',
    'case_status_added_successfully' => 'Case Status added successfully',
    'case_status_updated_successfully' => 'Case Status updated successfully',
    'case_status_changed_successfully' => 'Case status changed successfully',
    'case_status_deleted_successfully' => 'Case Status deleted successfully',
    'cannot_delete_case_status_used' => 'You can\'t delete Case Status because it is used in other module', // Corrected 'cant', 'it is'
    'case_type_added_successfully' => 'Case Type added successfully',
    'case_type_edited_successfully' => 'Case Type edited successfully',
    'case_type_status_changed_successfully' => 'Case Type status changed successfully',
    'case_type_deleted_successfully' => 'Case Type deleted successfully',
    'cannot_delete_case_type_used' => 'You can\'t delete Case Type because it is used in other module', // Corrected 'cant', 'it is'
    'client_added_successfully' => 'Client added successfully',
    'client_updated_successfully' => 'Client updated successfully', // Normalized 'Update' to 'updated'
    'client_deleted_successfully' => 'Client deleted successfully',
    'team_member_created_successfully' => 'Team member created successfully',
    'account_setup_successfully' => 'Account setup successfully',
    'team_member_updated_successfully' => 'Team member updated successfully',
    'cannot_delete_team_member_used' => 'You can\'t delete this team member because it\'s used in other modules', // Corrected 'cant', 'its'
    'team_member_deleted_successfully' => 'Team member deleted successfully',
    'court_added_successfully' => 'Court added successfully',
    'court_updated_successfully' => 'Court updated successfully',
    'court_status_changed_successfully' => 'Court status changed successfully',
    'court_deleted_successfully' => 'Court deleted successfully',
    'cannot_delete_court_used' => 'You can\'t delete Court because it is used in other module', // Corrected 'cant', 'it is'
    'backup_restored_successfully' => 'Backup Restored Successfully',
    'expense_added_successfully' => 'Expense added successfully',
    'expense_updated_successfully' => 'Expense Updated successfully',
    'expense_deleted_successfully' => 'Expense deleted successfully',
    'expense_type_added_successfully' => 'Expense type added successfully',
    'expense_type_updated_successfully' => 'Expense type updated successfully',
    'expense_type_status_changed_successfully' => 'Expense type status changed successfully',
    'expense_type_deleted_successfully' => 'Expense type deleted successfully',
    'database_backup_saved_successfully' => 'Database backup saved Successfully',
    'saved_successfully' => 'Saved Successfully', // Covers "Save Successfully"
    'invoice_sent_successfully' => 'Invoice has been sent successfully in email',
    'smtp_not_set_error' => 'Please first set SMTP detail in settings',
    'invoice_generated_successfully' => 'Invoice generated successfully',
    'invoice_updated_successfully' => 'Invoice Updated successfully',
    'invoice_deleted_successfully' => 'Invoice deleted successfully',
    'settings_saved_successfully' => 'Settings saved successfully', // Normalized 'Setting added'
    'judge_added_successfully' => 'Judge added successfully',
    'judge_updated_successfully' => 'Judge updated successfully',
    'judge_status_changed_successfully' => 'Judge status changed successfully',
    'judge_deleted_successfully' => 'Judge deleted successfully',
    'cannot_delete_tax_used' => 'You can\'t delete Tax because it is used in other module', // Corrected 'cant', 'it is'
    'permissions_updated_successfully' => 'Permissions updated successfully', // Normalized 'update'
    'password_changed_successfully' => 'Password changed successfully',
    'unable_to_process_request_this_time' => 'Unable to process request this time. Try again later',
    'current_password_do_not_match' => 'Your current password do not match our record',
    'profile_updated_successfully' => 'Profile updated successfully',
    'role_created_successfully' => 'Role created successfully',
    'role_updated_successfully' => 'Role updated successfully',
    'role_deleted_successfully' => 'Role deleted successfully',
    'service_created_successfully' => 'Service created successfully',
    'service_updated_successfully' => 'Service updated successfully',
    'service_deleted_successfully' => 'Service deleted successfully',
    'cannot_delete_service_used' => 'You can\'t delete service because it is used in other module', // Corrected 'cant', 'it is'
    'service_status_changed_successfully' => 'Service status changed successfully',
    'task_created_successfully' => 'Task Created successfully',
    'task_updated_successfully' => 'Task Updated successfully',
    'task_deleted_successfully' => 'Task deleted successfully',
    'vendor_added_successfully' => 'Financial added successfully',
    'vendor_updated_successfully' => 'Financial updated successfully', // Normalized 'update'
    'vendor_deleted_successfully' => 'Financial deleted successfully',

    'cannot_delete_role_has_permissions' => 'Cannot delete role with assigned permissions. Please remove permissions first.', // Reworded for clarity
    'cannot_delete_vendor_used' => 'You cannot delete financial because it is used in other module', // Corrected 'can not'
    'cannot_delete_client_used' => 'Client was used in other module so you cannot delete', // Corrected 'can not'
    'cannot_delete_case_type_used' => 'You can\'t delete Case Type because it is used in other module', // Handled duplicate
    'cannot_delete_court_type_used' => 'You can\'t delete Court Type because it is used in other module', // Handled duplicate
    'court_type_deleted_successfully' => 'Court Type deleted successfully', // Handled duplicate
    'court_type_status_changed_successfully' => 'Court Type status changed successfully', // Handled duplicate
    'court_type_updated_successfully' => 'Court type updated successfully',
    'court_type_added_successfully' => 'Court type added successfully',

];
