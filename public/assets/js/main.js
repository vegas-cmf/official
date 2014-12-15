$('#box-contact form').on('submit', function() {
    var form = $(this);
    var btn = form.find('button').button('loading');

    $.ajax({
        'url': '/contact',
        'method': 'post',
        'data': form.serialize()
    }).done(function(data) {
        form[0].reset();
        alertify.success(data.message);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        alertify.error(errorThrown);
    }).always(function() {
        btn.button('reset')
    });

    return false;
});