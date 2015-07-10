{% do assets.addCss('assets/vendor/jquery-ui/themes/smoothness/jquery-ui.css') %}
{% do assets.addJs('assets/vendor/jquery/dist/jquery.min.js') %}
{% do assets.addJs('assets/vendor/jquery-ui/ui/minified/jquery-ui.min.js') %}
{% do assets.addJs('assets/vendor/nestedSortable/jquery.mjs.nestedSortable.js') %}
{% do assets.addJs('assets/documentation/js/categories.js') %}

<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>{{ i18n._('Documentation categories') }}</h3>
            <div class="btn-group pull-right">
                <a class="btn btn-flat success" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'new']) }}">
                    + {{ i18n._('New category') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {% if(categories) %}
                <ol class="sortable">
                    {% for itemKey, item in categories %}
                        <li id="category_{{item.getId()}}" data-parent="{{item.parent}}">
                            <div class="categoryBox">
                                {{ item.name }}
                                <div align="right">
                                    <a class="btn btn-sm btn-default" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action': 'edit', 'params':item._id]) }}">Update</a>
                                    <a class="btn btn-sm confirm-delete" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'delete', 'params':item._id]) }}">Delete</a>
                                </div>
                            </div>
                            <ol id="children_{{item.getId()}}"></ol>
                        </li>
                    {% endfor %}
                </ol>
            {% else %}
                No records found.
            {% endif %}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right">
                <span class="btn btn-flat success btn-primary" id="update_tree">Update tree</span>
                <a class="btn btn-flat success btn-primary" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'index']) }}">
                    {{ i18n._('Cancel / Reload') }}
                </a>
            </div>            
        </div>
    </div>
</div>