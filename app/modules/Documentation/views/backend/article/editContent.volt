<div id="in">
    <form>
        <textarea id="code">{{article.content}}</textarea>
    </form>
</div>
<div id="out" class="markdown-view"></div>
<div id="menu">
    <span>Save As</span>
    <div id="saveas-markdown-db">
        <svg height="64" width="64" xmlns="http://www.w3.org/2000/svg">
            <g transform="scale(0.0625)">
                <path d="M950.154 192H73.846C33.127 192 0 225.12699999999995 0 265.846v492.308C0 798.875 33.127 832 73.846 832h876.308c40.721 0 73.846-33.125 73.846-73.846V265.846C1024 225.12699999999995 990.875 192 950.154 192zM576 703.875L448 704V512l-96 123.077L256 512v192H128V320h128l96 128 96-128 128-0.125V703.875zM767.091 735.875L608 512h96V320h128v192h96L767.091 735.875z" />
            </g>
        </svg>

        <span>Markdown Article</span>
    </div>
    <div id="saveas-markdown">
        <svg height="64" width="64" xmlns="http://www.w3.org/2000/svg">
            <g transform="scale(0.0625)">
                <path d="M950.154 192H73.846C33.127 192 0 225.12699999999995 0 265.846v492.308C0 798.875 33.127 832 73.846 832h876.308c40.721 0 73.846-33.125 73.846-73.846V265.846C1024 225.12699999999995 990.875 192 950.154 192zM576 703.875L448 704V512l-96 123.077L256 512v192H128V320h128l96 128 96-128 128-0.125V703.875zM767.091 735.875L608 512h96V320h128v192h96L767.091 735.875z" />
            </g>
        </svg>

        <span>Markdown File</span>
    </div>
    <div id="saveas-html">
        <svg height="64" width="64" xmlns="http://www.w3.org/2000/svg">
            <g transform="scale(0.0625) translate(64,0)">
                <path d="M608 192l-96 96 224 224L512 736l96 96 288-320L608 192zM288 192L0 512l288 320 96-96L160 512l224-224L288 192z" />
            </g>
        </svg>

        <span>HTML File</span>
    </div>
    <a id="close-menu">&times;</a>
</div>
<script>
    var articleId = '{{article.getId()}}';
    var articleSlug = '{{article.slug}}';
</script>
<script src="/assets/documentation/js/content-editor.js"></script>