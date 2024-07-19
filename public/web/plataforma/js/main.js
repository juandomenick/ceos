$(function(){
    $(".select2").select2({
        width: '100%',
        placeholder: $(this).prop('placeholder')
    });

    $(".select2").each(function () {
        if ($(this).hasClass('is-invalid')) {
            var select2;
            select2 = $(this).next();
            select2.addClass('border')
            select2.addClass('rounded')
            select2.addClass('border-danger')
        }
    });
});

