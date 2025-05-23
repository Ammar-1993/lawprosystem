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

$("#upload-demo").hide();
var fileTypes = ['jpg', 'jpeg', 'png'];
$('#upload').on('change', function () {

    var reader = new FileReader();
    if (this.files[0].size > 5242880) { // 2 mb for bytes.
        //alert('File size should not be more than 2MB');
        message.fire({
            type: 'error',
            title: 'Error' ,
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
            $('#demo_profile').hide();
            //$('#cancel_img').show();
            $uploadCrop.croppie('bind', {
                url: e.target.result

            }).then(function(){
                console.log('jQuery bind complete');
            });
        }else{
            message.fire({
                type: 'error',
                title: 'Error' ,
                text: 'Accept only .jpg .png image',
            });


        }
    }
    reader.readAsDataURL(this.files[0]);

});



$('#upload-result').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {

        $('#imagebase64').val(resp);

    });
});

var $imageupload = $('.imageupload');
$imageupload.imageupload();

$('#imageupload-disable').on('click', function () {
    $imageupload.imageupload('disable');
    $(this).blur();
})

$('#imageupload-enable').on('click', function () {
    $imageupload.imageupload('enable');
    $(this).blur();
})

$('#imageupload-reset').on('click', function () {
    $imageupload.imageupload('reset');
    $(this).blur();
});

$('#cancel_img').on('click', function () {

    $("#upload-demo").hide();
    $("#upload_img").hide();
    $('#upload-demo-i').show();
    $('#crop_image').show();
    $('#demo_profile').show();
    $('#remove_crop').show();


});

