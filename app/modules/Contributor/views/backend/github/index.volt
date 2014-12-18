{% set title = i18n._('Contributors') %}

<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>{{ title }}</h3>
            <div class="btn-group pull-right">
                <a class="btn btn-flat success" href="{{ url.get(['for':'admin/contributor', 'action':'refresh']) }}">
                    {{ i18n._('Refresh contributors') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ i18n._('Username') }}</th>
                    <th>{{ i18n._('Contributions') }}</th>
                    <th>{{ i18n._('Last update') }}</th>
                </tr>
                </thead>
                <tbody>
                {% if(contributors) %}
                    {% for item in contributors %}
                        <tr>
                            <td>{{ item.login }}</td>
                            <td>{{ item.contributions }}</td>
                            <td>
                                {% if item.updated_at %}
                                    {{ date('d-m-Y', item.updated_at) }}
                                {% endif %}
                            </td>
                        </tr>
                    {% endfor %}
                {% else %}
                    <tr>
                        <td colspan="3" align="center">{{ i18n._("No contributors found.")}}</td>
                    </tr>
                {% endif %}
                </tbody>
            </table>
        </div>
    </div>
</div>
