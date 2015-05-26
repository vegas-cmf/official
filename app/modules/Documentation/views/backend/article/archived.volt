<div class="table-wrapper products-table section">
    <div class="row">
        <div class="col-md-12">
            {% if article %}
            <h3>{{ i18n._('Archived versions of article:') }} <a href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action': 'edit', 'params':article._id]) }}">{{article.title}}</a></h3>
            {% else %}
            <h3>{{ i18n._('Parent article was not found (probably deleted)') }}</h3>
            {% endif %}
            <div class="btn-group pull-right">
                <a class="btn btn-flat success" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'index']) }}">
                    {{ i18n._('Back to index') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ i18n._('Title') }}</th>
                    <th>{{ i18n._('Version from') }}</th>
                    <th class="options">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {% if(page.items) %}
                    {% for item in page.items %}
                        <tr>
                            <td>
                                {{ item.title }}
                            </td>
                            <td>
                                {{ date('d-m-Y H:i:s', item.created_at) }}
                            </td>
                            <td align="right">
                                <a class="btn btn-sm btn-default" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action': 'showArchived', 'params':item._id]) }}">Show</a>
                                <a class="btn btn-sm confirm-delete" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'delete', 'params':item._id]) }}">Delete</a>
                            </td>
                        </tr>
                    {% endfor %}
                {% else %}
                    <tr>
                        <td colspan="3" align="center">No records found.</td>
                    </tr>
                {% endif %}
                </tbody>
            </table>
            {{ pagination(page) }}
        </div>
    </div>
</div>
