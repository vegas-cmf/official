{% do assets.addJs('assets/vendor/jquery/dist/jquery.min.js') %}
{% do assets.addJs('assets/vendor/jquery-ui/ui/minified/jquery-ui.min.js') %}
{% do assets.addJs('assets/documentation/js/articles.js') %}
{% do assets.addCss('assets/documentation/css/styles.css') %}

<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>{{ i18n._('Documentation articles') }}</h3>
            <div class="btn-group pull-right">
                <a class="btn btn-flat success" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'new']) }}">
                    {{ i18n._('+ New article') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {% set articles = articleService.getAllArticles(false) %}
            {% if(articles) %}
                {% for category, cArticles in articles %}
                <h4>{{ articleService.getCategoryPath(category) }}</h4>
                <table class="table table-hover sortable" data-category="{{category}}">
                    <thead>
                                <tr>
                                    <th>{{ i18n._('Title') }}</th>
                                    <th>{{ i18n._('Created at') }}</th>
                                    <th>{{ i18n._('Concerns versions') }}</th>
                                    <th class="options">&nbsp;</th>
                                </tr>
                    </thead>
                    <tbody>
                    {% for key, item in cArticles %}
                        <tr data-article="{{item.getId()}}" class="{% if item.published %}published{%else%}not-published{% endif %}">
                            <td>{{ item.title }}</td>
                                <td>{{ date('d-m-Y', item.created_at) }}</td>
                                <td>
                                    {% for vKey, version in articleService.getSupportedVersions(item.version) %}
                                        {% if vKey > 0 %},&nbsp;{% endif %}{{ version.version_id }}
                                    {% endfor %}
                                </td>
                                <td align="right">
                                    <a class="btn btn-sm btn-default" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action': 'show', 'params':item._id]) }}">{{ i18n._("Show")}}</a>
                                    <a class="btn btn-sm btn-default" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action': 'archived', 'params':item._id]) }}">{{ i18n._("Archived")}}</a>
                                    <a class="btn btn-sm btn-default" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action': 'edit', 'params':item._id]) }}">{{ i18n._("Update")}}</a>
                                    <a class="btn btn-sm confirm-delete" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'delete', 'params':item._id]) }}">{{ i18n._("Delete")}}</a>
                                </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
                {% endfor %}
            {% else %}
                <p>{{ i18n._("No articles found.")}}</p>
            {% endif %}
            </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right">
                <span class="btn btn-flat success btn-primary" id="update_positions">{{ i18n._('Update positions') }}</span>
                <a class="btn btn-flat success btn-primary" href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'index']) }}">
                    {{ i18n._('Cancel / Reload') }}
                </a>
            </div>            
        </div>
    </div>
</div>
