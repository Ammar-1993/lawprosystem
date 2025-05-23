$(document).ready(function () {
   countrySelect2 = $('.country-select2')
         stateSelect2 = $('.state-select2')
         citySelect2 = $('.city-select2')
 
   
    
    countrySelect2.select2({
        allowClear :true,
        ajax: {
            url: countrySelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id : $(countrySelect2.data('target')).val()
                };
            },
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
            },
            cache: true,
            delay: 250
        },
        placeholder: 'Select country',
        // minimumInputLength: 1,
    });

    stateSelect2.select2({
        allowClear :true,
        ajax: {
            url: stateSelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id : $(stateSelect2.data('target')).val()
                };
            },
            dataType: 'json',
            processResults: function (data) {
                 if($("#country").val() !='')
                {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
               }else{
                    return false;
               }
            },
            cache: true,
            delay: 250
        },
        placeholder: 'Select state',
        // minimumInputLength: 1,
    });

     citySelect2.select2({
        allowClear :true,
        ajax: {
            url: citySelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id : $(citySelect2.data('target')).val()
                };
            },
            dataType: 'json',
            processResults: function (data) {
                   if($("#state").val() !='')
                {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
               }else{
                return false;
               }
            },
            cache: true,
            delay: 250
        },
        placeholder: 'Select city',
        // minimumInputLength: 1,
    }); 
    

    $('.country-select2 , .state-select2 ').on('select2:select' ,function(e){
        var el = $(this);
        var clearInput = el.data('clear').toString();
        $(clearInput).val(null).trigger('change');        
    }) 
});