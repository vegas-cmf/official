<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Amsterdam Standard Vegas Team">

    <title>Vegas Content Management Framework - official page</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/vendor/alertify/themes/alertify.core.css" rel="stylesheet">
    <link href="/assets/vendor/alertify/themes/alertify.bootstrap.css" rel="stylesheet">

    <!-- Site CSS -->
    <link href="/assets/css/main.css" rel="stylesheet">
    {{ assets.outputCss() }}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                    <li><a href="{{ url.get(['for': 'admin/project', 'action': 'index']) }}">{{ i18n._('Projects') }}</a></li>
                    <li><a href="{{ url.get(['for': 'admin/contributor', 'action': 'index']) }}">{{ i18n._('Contributors') }}</a></li>
                    <li><a href="{{ url.get(['for': 'admin/user', 'action': 'index']) }}">{{ i18n._('Users') }}</a></li>
                    <li><a href="{{ url.get(['for': 'logout']) }}">{{ i18n._('Logout') }}</a></li>
                {% else %}
                    <li><a href="{{ url.get(['for': 'login']) }}">{{ i18n._('Login') }}</a></li>
                {% endif %}
            </ul>

        </div>
    </div>
</div>

<div class="container">
    <div id="banner" class="page-header">
        <div class="row">
            <div class="col-lg-12">
                <h1>Vegas CMF</h1>
                <p class="lead">
                    {{ i18n._('Vegas CMF is a complex Content Management Framework that allows you to easily build own CMS.') }}
                </p>
            </div>
        </div>
    </div>
    <div class="clearfix row">
        {{ flash.output() }}
        {{ content() }}
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted text-center">
            &copy; <a href="http://www.amsterdamstandard.com" target="_blank">Amsterdam Standard</a> 2014-2015
        </p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/vendor/alertify/alertify.min.js"></script>
<script src="/assets/js/main.js"></script>
{{ assets.outputJs() }}
</body>
</html>
