{% for user in users %}
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3">
        <div class="row">
            <a href="{{ user.html_url }}">
                <img src="{{ user.avatar_url }}" alt="{{ user.login }}" class="img-responsive" />
            </a>
        </div>
    </div>
{% endfor %}