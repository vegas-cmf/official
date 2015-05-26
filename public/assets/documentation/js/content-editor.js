var URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
    navigator.saveBlob = navigator.saveBlob || navigator.msSaveBlob || navigator.mozSaveBlob || navigator.webkitSaveBlob;
    window.saveAs = window.saveAs || window.webkitSaveAs || window.mozSaveAs || window.msSaveAs;

    // Because highlight.js is a bit awkward at times
    var languageOverrides = {
        js: 'javascript',
        html: 'xml'
    };

    var md = markdownit({
        highlight: function (code, lang) {
            if (languageOverrides[lang])
                lang = languageOverrides[lang];
            if (lang && hljs.getLanguage(lang)) {
                try {
                    return hljs.highlight(lang, code).value;
                } catch (e) {
                }
            }
            return '';
        }
    })
            .use(markdownitFootnote);


    var hashto;
    var numberOfChanges = -1;
    var lastUpdateTime = null;
    
    function update(e) {
        setOutput(e.getValue());

        clearTimeout(hashto);
        hashto = setTimeout(updateHash, 1000);
        numberOfChanges++;
    }
    
    var autosaveInterval = setInterval(function() {
        //console.log('numberOfChanges'+numberOfChanges);
        if(numberOfChanges > 0) {
            var timeFromLastUpdate = 9999;
            if(lastUpdateTime != null) {
                timeFromLastUpdate = Math.round(+new Date()/1000) - lastUpdateTime;
            }
            //console.log('timeFromLastUpdate'+timeFromLastUpdate);
            if(timeFromLastUpdate>60) updateArticle(editor.getValue(), 1);
        }
    }, 10 * 1000);

    function setOutput(val) {
        val = val.replace(/<equation>((.*?\n)*?.*?)<\/equation>/ig, function (a, b) {
            return '<img src="http://latex.codecogs.com/png.latex?' + encodeURIComponent(b) + '" />';
        });

        var out = document.getElementById('out');
        var old = out.cloneNode(true);
        out.innerHTML = md.render(val);

        var allold = old.getElementsByTagName("*");
        if (allold === undefined)
            return;

        var allnew = out.getElementsByTagName("*");
        if (allnew === undefined)
            return;

        for (var i = 0, max = Math.min(allold.length, allnew.length); i < max; i++) {
            if (!allold[i].isEqualNode(allnew[i])) {
                out.scrollTop = allnew[i].offsetTop;
                return;
            }
        }
    }

    var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        mode: 'gfm',
        lineNumbers: false,
        matchBrackets: true,
        lineWrapping: true,
        theme: 'base16-light',
        extraKeys: {"Enter": "newlineAndIndentContinueMarkdownList"}
    });

    editor.on('change', update);





    document.addEventListener('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var reader = new FileReader();
        reader.onload = function (e) {
            editor.setValue(e.target.result);
        };

        reader.readAsText(e.dataTransfer.files[0]);
    }, false);





    function saveAsMarkdown() {
        save(editor.getValue(), articleSlug+".md");
    }

    function saveAsMarkdownDb() {
        save(editor.getValue(), "DB");
    }

    function saveAsHtml() {
        save(document.getElementById('out').innerHTML, articleSlug+".html");
    }

    document.getElementById('saveas-markdown').addEventListener('click', function () {
        saveAsMarkdown();
        hideMenu();
    });

    document.getElementById('saveas-markdown-db').addEventListener('click', function () {
        saveAsMarkdownDb();
        hideMenu();
    });
    
    document.getElementById('save-db-link').addEventListener('click', function () {
        saveAsMarkdownDb();
        hideMenu();
    });

    document.getElementById('saveas-html').addEventListener('click', function () {
        saveAsHtml();
        hideMenu();
    });

    function save(code, name) {
        var blob = new Blob([code], {type: 'text/plain'});

        if (window.saveAs) {
            window.saveAs(blob, name);
        } else if (navigator.saveBlob) {
            navigator.saveBlob(blob, name);
        } else {
            if (name == 'DB') {
                updateArticle(code);
            }
            else {
                url = URL.createObjectURL(blob);
                var link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", name);
                var event = document.createEvent('MouseEvents');
                event.initMouseEvent('click', true, true, window, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
                link.dispatchEvent(event);
            }
        }
    }



    var menuVisible = false;
    var menu = document.getElementById('menu');

    function showMenu() {
        menuVisible = true;
        menu.style.display = 'block';
    }

    function hideMenu() {
        menuVisible = false;
        menu.style.display = 'none';
    }

    document.getElementById('close-menu').addEventListener('click', function () {
        hideMenu();
    });

    function updateArticle(code, archival) {
        if(archival === undefined) archival = 0;
        var contentRendered = $('#out').html();
        $.ajax({
            'url': '/admin/documentation/articles/updateContent',
            'method': 'post',
            'data': {
                "article": articleId,
                "archival": archival,
                "content": code,
                "contentRendered": contentRendered
            }
        }).done(function (data) {
            numberOfChanges = 0;
            lastUpdateTime = Math.round(+new Date()/1000);
            alertify.success(data.message);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alertify.error(errorThrown);
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.keyCode == 83 && (e.ctrlKey || e.metaKey)) {
            e.shiftKey ? showMenu() : saveAsMarkdownDb();

            e.preventDefault();
            return false;
        }

        if (e.keyCode === 27 && menuVisible) {
            hideMenu();
            e.preventDefault();
            return false;
        }
    });




    function updateHash() {
        window.location.hash = btoa(// base64 so url-safe
                RawDeflate.deflate(// gzip
                        unescape(encodeURIComponent(// convert to utf8
                                editor.getValue()
                                ))
                        )
                );
    }

    if (window.location.hash) {
        var h = window.location.hash.replace(/^#/, '');
        if (h.slice(0, 5) == 'view:') {
            setOutput(decodeURIComponent(escape(RawDeflate.inflate(atob(h.slice(5))))));
            document.body.className = 'view';
        } else {
            editor.setValue(
                    decodeURIComponent(escape(
                            RawDeflate.inflate(
                                    atob(
                                            h
                                            )
                                    )
                            ))
                    );
            update(editor);
            editor.focus();
        }
    } else {
        update(editor);
        editor.focus();
    }