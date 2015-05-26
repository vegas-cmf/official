{% set title = i18n._('Documentation versions') %}

<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>{{ title }}</h3>
            <div class="btn-group pull-right">
                <a class="btn btn-flat success" href="{{ url.get(['for':'admin/documentation/version', 'action':'new']) }}">
                    {{ i18n._('+ New version') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ i18n._('Version ID') }}</th>
                    <th>{{ i18n._('Created at') }}</th>
                    <th class="options">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {% if(page.items) %}
                    {% for item in page.items %}
                        <tr>
                            <td>{{ item.version_id }}</td>
                            <td>{{ date('d-m-Y', item.created_at) }}</td>
                            <td align="right">
                                <a class="btn btn-sm btn-default" href="{{ url.get(['for':'admin/documentation/version', 'action': 'edit', 'params':item._id]) }}">{{ i18n._("Update")}}</a>
                                <a class="btn btn-sm confirm-delete" href="{{ url.get(['for':'admin/documentation/version', 'action':'delete', 'params':item._id]) }}">{{ i18n._("Delete")}}</a>
                            </td>
                        </tr>
                    {% endfor %}
                {% else %}
                    <tr>
                        <td colspan="4" align="center">{{ i18n._("No versions found.")}}</td>
                    </tr>
                {% endif %}
                </tbody>
            </table>
            {{ pagination(page) }}
        </div>
    </div>
</div>
