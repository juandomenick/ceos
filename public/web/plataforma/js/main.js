$(function () {
    $(".select2").select2({
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

    $('form').on('submit', function () {
        $("button").prop('type', 'submit')
            .append('<div class="spinner-border ml-2" id="btn-loading" style="height:1rem; width: 1rem;"></div>')
            .prop('disabled', true)
            .css({
                'pointer-events': 'none',
                'transition': 'none',
                'animation': 'none'
            })
    })
});

