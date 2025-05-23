// Validation

$('#add_vendor').validate({   
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {},
        messages: {},
        errorPlacement: function (error, element) {            
            error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function (e) {
          $('#show_loader').removeClass('fa-save');
               $('#show_loader').addClass('fa-spin fa-spinner');
               $("button[name='btn_add_client']").attr("disabled", "disabled").button('refresh');
            return true;
        }
    })

// Get state & city

 function getState(id) {
   
       if(id==""){
            $('#states').html('');
        }else{
            $('#states').html('');
             $('#cities').html('');
            $('#states').prepend($('<option></option>').html('Loading...'));
        }
   
       if (id != '') {
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               }
           });
           $.ajax({
               url: "{{ url('getStateByCountry')}}",
               method: "POST",
               data: {
                   id: id
               },
               success: function (result) {
                   if (result.errors)
                   {
                       $('.alert-danger').html('');
                   }
                   else
                   {
                       $('#states').html(result);
                   }
               }
           });
       }
   }
   
   
   function getCity(id) {
   
   
       if(id==""){
            $('#cities').html('');
        }else{
            $('#cities').html('');
            $('#cities').prepend($('<option></option>').html('Loading...'));
        }
       if (id != '') {
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               }
           });
           $.ajax({
               url: "{{ url('getCitiesByState')}}",
               method: "POST",
               data: {
                   id: id
               },
               success: function (result) {
                   if (result.errors)
                   {
                       $('.alert-danger').html('');
                   }
                   else
                   {
                       $('#cities').html(result);
                   }
               }
           });
       }
   }
  