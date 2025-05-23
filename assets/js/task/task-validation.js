"use strict";

// Check if translations are available from Blade injection
if (typeof taskValidationMessages !== 'undefined') {

    // Variables potentially needed (keep these)
    var select2Case = $("#select2Case").val();
    var date_format_datepiker = $("#date_format_datepiker").val(); // This might need localization itself
    // Get current language if passed from Blade, otherwise default or detect
    var currentLang = typeof currentLang !== 'undefined' ? currentLang : (document.documentElement.lang || 'en');
    const select2RtlDir = (currentLang === 'ar' ? 'rtl' : 'ltr'); // Define RTL direction for Select2

    var FormControlsClient = {
        init: function () {
            var btn = $("form :submit");
            // TODO: Verify if #add_client is the correct form ID for tasks.
            $("#add_client").validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    task_subject: "required",
                    start_date: "required",
                    end_date: "required",
                    project_status_id: "required",
                    priority: "required",
                    "assigned_to[]": { // Use quotes for name with special characters
                        required: true,
                    },
                },
                // Use injected messages via taskValidationMessages object
                messages: {
                    task_subject:       taskValidationMessages.subject,
                    start_date:         taskValidationMessages.start_date,
                    end_date:           taskValidationMessages.end_date,
                    project_status_id:  taskValidationMessages.project_status_id,
                    priority:           taskValidationMessages.priority,
                    "assigned_to[]": {
                        required:       taskValidationMessages.assigned_to_required, // Access the specific key
                    },
                },
                errorPlacement: function (error, element) {
                    // If using Select2, place error after the Select2 container
                     if (element.hasClass('select2-hidden-accessible')) {
                         error.insertAfter(element.next('.select2-container')).addClass('text-danger');
                     } else {
                        error.appendTo(element.parent()).addClass("text-danger");
                     }
                },
                submitHandler: function (form) { // Pass form
                    $("#show_loader").removeClass("fa-save");
                    $("#show_loader").addClass("fa-spin fa-spinner");
                    // Ensure the button name 'btn_add_user' is correct for this form
                    $(form).find("button[name='btn_add_user']")
                        .attr("disabled", "disabled")
                        .button("refresh");
                    // return true; // Or use form.submit()
                    form.submit(); // Explicitly submit
                },
            });
        },
    }; // End FormControlsClient

    jQuery(document).ready(function () {
        FormControlsClient.init();

        // --- Select2 Localization ---
        $("#related_id").select2({
            ajax: {
                url: select2Case, // Make sure this URL is correct for fetching customers/cases
                data: function (params) { return { search: params.term }; },
                dataType: "json",
                processResults: function (data) {
                    // console.log(data);
                    return {
                        results: data.items.map(function (item) {
                            // Ensure your backend provides translated names if necessary
                            return {
                                id: item.id,
                                text: `${item.first_name || ''} ${item.middle_name || ''} ${item.last_name || ''}`.trim(), // Safer concatenation
                                otherfield: item,
                            };
                        }),
                        pagination: { more: data.pagination },
                    };
                },
                delay: 250, // Standard delay
            },
            placeholder: taskValidationMessages.ph_search_customer, // Use injected placeholder
            templateResult: getfName, // Keep custom template
            dir: select2RtlDir // Add direction
        });

        // Note: Duplicate initializations found below. Applying localization to all.
        // Consider removing duplicates if they are unintentional.

        $("#project_status_id").select2({
            allowClear: true,
            placeholder: taskValidationMessages.ph_select_status, // Use injected placeholder
            dir: select2RtlDir // Add direction
        });

        $("#priority").select2({
            allowClear: true,
            placeholder: taskValidationMessages.ph_select_priority, // Use injected placeholder
            dir: select2RtlDir // Add direction
        });

        $("#assigned_to").select2({
            allowClear: true,
            placeholder: taskValidationMessages.ph_select_users, // Use injected placeholder
            multiple: true,
            dir: select2RtlDir // Add direction
        });

        $("#related").select2({
            allowClear: true,
            placeholder: taskValidationMessages.ph_nothing_selected, // Use injected placeholder
            dir: select2RtlDir // Add direction
        });

        // --- Remove or consolidate duplicate initializations below ---
        // $("#project_status_id").select2({...}); // Duplicate
        // $("#priority").select2({...}); // Duplicate
        // $("#assigned_to").select2({...}); // Duplicate
        // $("#related").select2({...}); // Duplicate
         // --- End Duplicate Section ---

        // --- Date Picker Localization ---
        const datepickerOptions = {
            format: date_format_datepiker, // Check if this format needs localization
            language: currentLang, // Use language from Blade/detection
            autoclose: true,
            todayHighlight: true,
            rtl: (currentLang === 'ar') // Set RTL mode for Arabic
        };

        $(".dateFrom").datepicker(datepickerOptions)
            .on("changeDate", function (selected) {
                var startDate = selected.date ? new Date(selected.date.valueOf()) : null;
                $(".dateTo").datepicker("setStartDate", startDate);
            })
            .on("clearDate", function (selected) {
                 $(".dateTo").datepicker("setStartDate", null);
            });

        $(".dateTo").datepicker(datepickerOptions)
            .on("changeDate", function (selected) {
                var endDate = selected.date ? new Date(selected.date.valueOf()) : null;
                $(".dateFrom").datepicker("setEndDate", endDate);
            })
            .on("clearDate", function (selected) {
                $(".dateFrom").datepicker("setEndDate", null);
            });
        // --- End Date Picker Localization ---


        $("#related").on("change", function () {
            var optionSelected = $(this).find("option:selected");
            var label_name = optionSelected.val();
            // This logic remains the same - checks value, not text
            if (label_name == "case") {
                $(".task_selection").removeClass("hide");
            } else {
                $(".task_selection").addClass("hide");
            }
        });
    }); // End document ready

    // This function formats data, doesn't need direct text localization unless you add labels here
    function getfName(data) {
        if (!data.id) { return data.text; } // Return placeholder/searching text
        data = data.otherfield;
        if (!data) { return 'Error: Invalid data'; } // Basic check
        var name = `${data.first_name || ''} ${data.middle_name || ''} ${data.last_name || ''}`.trim();
        var caseNum = data.case_number || ''; // Handle potentially missing case_number
        // Consider adding localized labels if needed: e.g., "<b>" + taskValidationMessages.label_name + ":</b> " + name
        var $html = $("<p style='margin-bottom: 0;'><b>" + name + "</b>" + (caseNum ? "<br>" + caseNum : "") + "</p>");
        return $html;
    }

} else {
    // Fallback or error if translations weren't injected
    console.error('Task validation messages object (taskValidationMessages) not found. Check Blade injection.');
    // Validation might still work but show default English messages or fail based on jQuery Validate setup
}