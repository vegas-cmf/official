<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PDF</title>

    <link rel="stylesheet" href="/assets/vendor/markdown-editor/base16-light.css">
    <link rel="stylesheet" href="/assets/vendor/markdown-editor/default.css">
    <link rel="stylesheet" href="/assets/documentation/css/markdown.css">
</head>
<body>
    <div>
        <h1>Vegas CMF [version: {{version.version_id}}]</h1>
        <hr/> 
        <h2>Table of Contents</h2>
        {% set categories  = articleService.getAllCategories('array') %}
        {% set articles = articleService.getAllArticles(true,version._id) %}
        {% for categoryId, categoryArray in categories %}
            {% set numberOfParents = (categoryArray['parents'] | length)-1 %}
            {% if articles[categoryId] is defined %}
                <div class="row">
                    <div style="padding-left: {{numberOfParents*15}}px;">
                        <h5>{{categoryArray['name']}}</h5>
                        <ul>
                            {% for article in articles[categoryId] %}
                                <li>{{article.title}}</li>
                            {% endfor %}
                        </ul>
                    </div>
                </div>
            {% endif %}
        {% endfor %}
        <hr/>   
        {% for categoryId, articleGroup in articles %}
        {% set category = articleService.getCategory(categoryId) %}
        {% if (articleGroup | length)> 0  %}<h2>{{category.name}}</h2>{% endif %}
        {% for article in articleGroup %}
        <h3>{{article.title}}</h3>
        <hr/>
        <div class="markdown-view">{{articleService.adjustContent(article.contentRendered)}}</div>
        {% endfor %}
        {% endfor %}
    </div>
</body>
</html>