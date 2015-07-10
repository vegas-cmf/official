<!DOCTYPE html>
<html>
<head>
  <title>Vegas Content Management Framework - official page</title>
  <script src="/assets/vendor/markdown-editor/markdown-it.js"></script>
  <script src="/assets/vendor/markdown-editor/markdown-it-footnote.js"></script>
  <script src="/assets/vendor/markdown-editor/highlight.pack.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/lib/codemirror.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/overlay.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/xml/xml.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/markdown/markdown.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/gfm/gfm.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/javascript/javascript.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/css/css.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/htmlmixed/htmlmixed.js"></script>
  <script src="/assets/vendor/markdown-editor/codemirror/lib/util/continuelist.js"></script>
  <script src="/assets/vendor/markdown-editor/rawinflate.js"></script>
  <script src="/assets/vendor/markdown-editor/rawdeflate.js"></script>
  <script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="/assets/vendor/alertify/alertify.min.js"></script>
  <link href="/assets/css/bootstrap.css" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="/assets/vendor/alertify/themes/alertify.bootstrap.css" rel="stylesheet">
  <link href="/assets/vendor/alertify/themes/alertify.core.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/vendor/markdown-editor/base16-light.css">
  <link rel="stylesheet" href="/assets/vendor/markdown-editor/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="/assets/vendor/markdown-editor/default.css">
  <link rel="stylesheet" href="/assets/documentation/css/content-editor.css">
  <link rel="stylesheet" href="/assets/documentation/css/markdown.css">
  {{ assets.outputCss() }}
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url.get(['for': 'root']) }}">cmf.vegas</a>
            <button data-target="#navbar-main" data-toggle="collapse" type="button" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar-main" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url.get(['for': 'root']) }}#box-docs">{{ i18n._('Learn') }}</a></li>
                <li><a href="{{ url.get(['for': 'root']) }}#box-tweets">{{ i18n._("What's new?") }}</a></li>
                <li><a href="{{ url.get(['for': 'root']) }}#box-projects">{{ i18n._('Projects on Vegas') }}</a></li>
                <li><a href="{{ url.get(['for': 'root']) }}#box-contact">{{ i18n._('Contact') }}</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {% if auth.isAuthenticated() %}
                    <li><a id="save-db-link">{{ i18n._('Save') }}</a></li>
                    <li><a href="{{ url.get(['for': 'admin/documentation/article', 'action': 'editContent', 'params': article.getId()]) }}">{{ i18n._('Revert not saved') }}</a></li>
                    <li><a href="{{ url.get(['for': 'admin/documentation/article', 'action': 'edit', 'params': article.getId()]) }}">{{ i18n._('Article settings') }}</a></li>
                {% endif %}
            </ul>
        </div>
    </div>
</div>
    {{ assets.outputJs() }}
    {{ flash.output() }}
    {{ content() }}
</body>
</html>