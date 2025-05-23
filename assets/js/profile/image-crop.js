$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
"use strict";
$("#upload-demo-i").hide();
$("#upload-demo").hide();
$("#upload_img").hide();



$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

var fileTypes = ['jpg', 'jpeg', 'png'];
$('#upload').on('change', function () {


    var reader = new FileReader();


    if (this.files[0].size > 5242880) { // 2 mb for bytes.
        //alert('File size should not be more than 2MB');
        message.fire({
            type: 'error',
            title: 'Error',
            text: 'File size should not be more than 5MB',
        });
        return false;
    }
    reader.onload = function (e) {
        result = e.target.result;
        arrTarget = result.split(';');
        tipo = arrTarget[0];

        if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
            $("#upload-demo").show();
            $("#upload_img").show();
            $('#upload-demo-i').hide();
            $('#crop_image').hide();
            $('#remove_crop').hide();
            $('#cancel_img').show();
            $('#demo_profile').hide();


            $uploadCrop.croppie('bind', {
                url: e.target.result

            }).then(function () {
                console.log('jQuery bind complete');
            });
        } else {
            message.fire({
                type: 'error',
                title: 'Error',
                text: 'Accept only .jpg .png image',
            });

            // alert('Accept only .jpg .png image types');

        }
    };
    reader.readAsDataURL(this.files[0]);


});


var elementClicked;

$('.upload-result').on('click', function (ev) {

    elementClicked = true;

    var url = $('#upload').attr("data-src");

    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {

        $.ajax({
            url: "{{ url('admin/image-crop')}}",
            type: "POST",
            data: {"image": resp, "id": url},
            success: function (data) {
                html = '<img src="' + resp + '" />';

                $("#upload-demo-i").show();
                $("#upload-demo").hide();
                $("#upload_img").hide();
                $("#crop_image").hide();
                $("#remove_crop").hide();
                $("#cancel_img").hide();
                $("#upload-demo-i").html(html);

                message.fire({
                    type: 'success',
                    title: 'Success',
                    text: 'image updated successfully.',
                });

            }
        });
    });
});

$('#cancel_img').on('click', function () {

    if (elementClicked != true) {
        $('#crop_image').show();

    } else {
        $('#upload-demo-i').show();
    }
    $(this).hide();
    $('#upload-demo').hide();
    $('#demo_profile').show();
    $('#remove_crop').show();
    $('#upload').val(null);
    $("#upload_img").hide();

});

$('#upload-result').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {

        $('#imagebase64').val(resp);

    });
});

