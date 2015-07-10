$(document).ready(function () {
    $('.sortable li').each(function(){
        var parentId = $(this).data('parent');
        if(parentId!=null) {
            var parentChildren = $('#children_'+parentId);
            if(parentChildren) {
                $(this).appendTo(parentChildren);
            }
        }
    });    
    
    $('.sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        maxLevels: 6,
        /*change: function () {
            setTimeout(function(){ updateTree(); }, 500);
        }*/
    });
    
    $('#update_tree').click(function(){
        updateTree();
    });
    
    var updateTree = function () {
        serialized = $('ol.sortable').nestedSortable('serialize');
        //console.log(serialized);
        $.ajax({
            'url': '/admin/documentation/categories/treeUpdate',
            'method': 'post',
            'data': serialized
        }).done(function (data) {
            //console.log(data);
            alertify.success(data.message);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alertify.error(errorThrown);
        });
    }
});
