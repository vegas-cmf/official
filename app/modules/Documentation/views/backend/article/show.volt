{% do assets.addCss('assets/vendor/markdown-editor/base16-light.css') %}
{% do assets.addCss('assets/vendor/markdown-editor/default.css') %}
{% do assets.addCss('assets/documentation/css/markdown.css') %}

<div class="table-wrapper products-table section">
    <div class="row header">
        <div class="col-md-12">
            <h3>{{record.title}}</h3>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="markdown-view">
                {{record.content_rendered}}
            </div>
            <a href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'index']) }}" class="btn pull-right">{{ i18n._('Back to overview') }}</a>
            <a href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'editContent', 'params': record._id]) }}" class="btn pull-right">{{ i18n._('Edit content') }}</a>
        </div>
    </div>
</div>
