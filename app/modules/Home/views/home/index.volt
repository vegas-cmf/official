<div class="col-lg-12" id="box-docs">
    <div class="jumbotron">
        <h2 class="col-xs-6">
            <a href="https://vegas-cmf.github.io" target="_blank">
                <i class="fa fa-graduation-cap"></i> {{ i18n._('read the docs') }}
            </a>
        </h2>
        <h2 class="col-xs-6">
            <a href="https://github.com/vegas-cmf" target="_blank">
                <i class="fa fa-github"></i> {{ i18n._('check our github') }}
            </a>
        </h2>
        <div class="clearfix"></div>
    </div>
</div>

<div class="col-lg-12" id="box-tweets">
    <div class="inner cover">
        <h2>@VegasCMF</h2>
        <a class="twitter-timeline" href="https://twitter.com/VegasCMF" data-widget-id="542687318176698369">@VegasCMF</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
</div>

<div class="col-lg-12" id="box-contact">
    <div class="row">
        <div class="col-lg-6">
            <div class="inner cover">
                <h2>{{ i18n._('Projects') }}</h2>
                {{ serviceManager.get('project:gallery').render() }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="inner cover">
                <h2>{{ i18n._('Contact us') }}</h2>
                <form action="{{ url.get(['for': 'contact']) }}" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-lg-6">
                            {{ contactForm.get('name') }}
                        </div>
                        <div class="col-lg-6">
                            {{ contactForm.get('email') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            {{ contactForm.get('content') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10">
                            <p class="lead">
                                {{ i18n._('Keep calm and send us some nice message!') }}
                            </p>
                        </div>
                        <div class="col-lg-2">
                            {{ contactToken.render() }}
                            <button data-loading-text="{{ i18n._('Sending...') }}" class="btn btn-primary pull-right" type="submit">{{ i18n._('Send') }}</button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="box-contact">
    <div class="inner cover">
        <h2>{{ i18n._('Our brave contributors') }}</h2>
        {{ serviceManager.get('contributor:gitHub').render() }}
    </div>
</div>
