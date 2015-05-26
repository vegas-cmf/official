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
            <h4>{{ i18n._('Preview') }}</h4>
            <hr/>
            <div class="markdown-view">
                {{record.contentRendered}}
            </div>
            <br/>
            <h4>{{ i18n._('Plaintext') }}</h4>
            <hr/>
            <pre class="markdown-plaintext">{{record.content}}</pre>
        </div>
            
        <a href="{{ url.get(['for': router.getMatchedRoute().getName(), 'action':'archived', 'params': record.parent]) }}" class="btn pull-right">{{ i18n._('Back to overview') }}</a>
    </div>
</div>
