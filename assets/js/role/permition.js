$(document).ready(function () {
    $(".permition_view").click(function () {
        if ($(this).is(':checked')) {
        } else {
            var $add = $(this).closest('tr').find('.permition_add').removeAttr('checked');
            var $edit = $(this).closest('tr').find('.permition_edit').removeAttr('checked');
            var $delete = $(this).closest('tr').find('.permition_delete').removeAttr('checked');
        }
    });

    $(".all_view").click(function () {
        if ($(this).is(':checked')) {
            var $view = $('.permition_view').prop("checked", true);
        } else {
            var $view = $('.permition_view').prop("checked", false);

            var $delete = $('.permition_delete').prop("checked", false);
            var $edit = $('.permition_edit').prop("checked", false);
            var $add = $('.permition_add').prop("checked", false);

            var $add = $('.all_add').prop("checked", false);
            var $add = $('.all_edit').prop("checked", false);
            var $add = $('.all_delete').prop("checked", false);
        }
    });


    $(".all_add").click(function () {
        if ($(this).is(':checked')) {
            var $add = $('.permition_add').prop("checked", true);
        } else {
            var $add = $('.permition_add').prop("checked", false);
        }
    });

    $(".all_edit").click(function () {
        if ($(this).is(':checked')) {
            var $edit = $('.permition_edit').prop("checked", true);
        } else {
            var $edit = $('.permition_edit').prop("checked", false);
        }
    });

    $(".all_delete").click(function () {
        if ($(this).is(':checked')) {
            var $delete = $('.permition_delete').prop("checked", true);
        } else {
            var $delete = $('.permition_delete').prop("checked", false);
        }
    });
});
