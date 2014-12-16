<div id="project-carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        {% for key, project in projects %}
            <li data-target="#project-carousel" data-slide-to="{{ key }}"{{ key ? '' : ' class="active"' }}></li>
        {% endfor %}
    </ol>
    <div class="carousel-inner" role="listbox">
        {% for key, project in projects %}
            <div class="item{{ key ? '' : ' active' }}">
                {% if project.getThumbnail() %}
                    <img src="{{ project.getThumbnail() }}" alt="{{ project.name }}">
                {% endif %}
                <div class="carousel-caption">
                    <h3>{{ project.name }}</h3>
                    <p><a href="{{ project.url }}" target="_blank">{{ project.url }}</a></p>
                </div>
            </div>
        {% endfor %}
    </div>
    <a class="left carousel-control" href="#project-carousel" role="button" data-slide="prev">
        <span class="control-left fa-stack fa-lg">
            <i class="fa fa-chevron-left"></i>
        </span>
    </a>
    <a class="right carousel-control" href="#project-carousel" role="button" data-slide="next">
        <span class="control-right fa-stack fa-lg">
            <i class="fa fa-chevron-right"></i>
        </span>
    </a>
</div>