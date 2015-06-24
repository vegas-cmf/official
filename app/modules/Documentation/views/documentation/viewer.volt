{% do assets.addCss('assets/vendor/markdown-editor/base16-light.css') %}
{% do assets.addCss('assets/vendor/markdown-editor/default.css') %}
{% do assets.addCss('assets/documentation/css/markdown.css') %}
{% do assets.addJs('assets/documentation/js/frontend.js') %}
<ul class="breadcrumb">
    <li>
        {{ i18n._('Documentation') }}
    </li>
    {% if versionSlug is defined and versionSlug != '' %}
        <li>{{ versionSlug }}</li>
        {% if activeArticle and activeArticle.category %}
            {% for parent in categoryService.getParentsNames(activeArticle.category) %}
                    <li>{{parent}}</li>
            {% endfor %}
            <li>{{categories[activeArticle.category]['name']}}</li>
            <li class="active">{{activeArticle.title}}</li>
        {% endif %}
    {% endif %}
</ul>
<div class="col-lg-3">
    <h3>{{ i18n._('Documentation') }}</h3>
    <div class="clearfix form-group">
        <label for="title">{{ i18n._('Vegas version') }}:</label>
        <select class="form-control" id="version" name="version">
            <option value=''>{{ i18n._('all') }}</option>

            {% for versionId in versions %}
                <option {% if versionSlug == versionId %}selected{%endif%}>
                    {{versionId}}
                </option>
            {% endfor %}
        </select>
    </div>
    <form class="form-search" method="get" action="{{ url.get(['for': 'documentation', 'action': 'viewer']) }}{{versionSlug}}">
        <div class="row">
            <div class="col-md-9"><input type="text" class="form-control" name="search" placeholder="Search" value="{{searchQuery}}"></div>
            <div class="col-md-3"><button type="submit" class="form-control search"></button></div>
        </div>
    </form>
    {% for versionRecordId, versionId in versions %}
        {% if versionSlug is empty or versionSlug == versionId %}
            {% set articles = articleService.getAllArticles(true,versionRecordId) %}
            <h4>{{ i18n._('Vegas version') }} {{ versionId }}</h4>
            [ <a href="{{ url.get(['for': 'documentation/pdf', 'params': versionId]) }}">download PDF</a> ]
            {% for categoryId, categoryArray in categories %}
                {% set numberOfParents = (categoryArray['parents'] | length)-1 %}
                
                {% if articleService.countArticles(categoryId,articles) %}
                    <div class="row">
                        <div class="col-lg-{{12-numberOfParents}} col-lg-offset-{{numberOfParents}}">
                            <h5>{{categoryArray['name']}}</h5>
                            {% if articles[categoryId] is defined %}
                            <ul>
                                {% for article in articles[categoryId] %}
                                    <li>
                                        <a href="{{ url.get(['for': 'documentation', 'action': 'viewer']) }}{{versionId}}/{{categoryArray['slug']}}/{{article.slug}}">
                                            {{article.title}}
                                        </a>
                                    </li>
                                {% endfor %}
                            </ul>
                            {% endif %}
                        </div>
                    </div>
                {% endif %}
            {% endfor %}
        {% endif %}
    {% endfor %}
</div>
<div class="col-lg-9">
    {% if searchQuery %}
        <h3>{{ i18n._('Search results') }}</h3>
        {% set searchResults = articleService.search(searchQuery,versionSlug) %}
        {% if searchResults %}
            <ul>
            {% for article in searchResults %}
                {% set category = categoryService.getObject(article.category) %}
                {% if versionSlug != '' %}
                    {% set articleVersionSlug = versionSlug %}
                {% else %}
                    {% set articleVersionSlug = articleService.getLastConnectedVersionSlug(article.version) %}
                {% endif %}
                <li>
                    <a href="{{ url.get(['for': 'documentation', 'action': 'viewer']) }}{{articleVersionSlug}}/{{category.slug}}/{{article.slug}}">
                        {{category.name}} - {{article.title}}
                    </a>
                </li>
            {% endfor %}
            </ul>
        {% else %}
            <strong>{{searchQuery}}</strong> {{ i18n._('not found') }}
        {% endif %}
    {% elseif activeArticle %}
        <h3>{{activeArticle.title}}</h3>
        <hr/>
        <div class="markdown-view">{{activeArticle.contentRendered}}</div>
    {% endif %}
</div>