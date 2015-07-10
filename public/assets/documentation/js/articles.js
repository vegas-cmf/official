$(document).ready(function () {
    $('.sortable tbody').sortable().disableSelection();
    
    $('#update_positions').click(function(){
        updatePositions();
    });
    
    var updatePositions = function () {
        var data = {};
        $('.sortable tbody').each(function(){
            var category = $(this).parent().data('category');
            var articles = [];
            $(this).find('tr').each(function(){
                if($(this).data('article')) articles.push($(this).data('article'));
            });
            data[category] = articles;
        });

        $.ajax({
            'url': '/admin/documentation/articles/updatePositions',
            'method': 'post',
            'data': data
        }).done(function (data) {
            alertify.success(data.message);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alertify.error(errorThrown);
        });
    }
});
