$(document).ready(function() {

    $('input[type="file"][data-form-element-upload]').each(function() {
        var uploader = $(this);

        var renumber = function() {
            uploader.closest('form').each(function() {
                var index = 0;

                $(this).find('[data-jq-upload-preview]>div').each(function() {
                    $(this).find('input, select, textarea').each(function() {
                        var name = $(this).attr('name');
                        name = name.replace(/\[[0-9]\]+/g, '[' + index + ']');
                        $(this).attr('name', name);
                    });

                    index++;
                });

                $(this).find('[data-jq-upload-preview-stored]').each(function() {
                    $(this).find('input, select, textarea').each(function() {
                        var name = $(this).attr('name');
                        name = name.replace(/\[[0-9]\]+/g, '[' + index + ']');
                        $(this).attr('name', name);
                    });

                    index++;
                });
            });
        };

        uploader.closest('form').each(function() {
            $(this).find('[data-jq-upload-preview-stored]').find('button').click(function(clickEvent) {
                $(this).closest('[data-jq-upload-preview-stored]').remove();
                clickEvent.preventDefault();
            });
        });

        var options = {
            url: uploader.data('url'),
            preview: {
                selector: '[data-for-id=' + uploader.data('id') + '] [data-jq-upload-preview]',
                container: '[data-jq-upload-preview-stored]'
            },
            selectFileText: uploader.data('button-add-label'),
            trigger: {
                type:  uploader.data('trigger-type'),
                attributes: {
                    class: 'btn btn-form-submit'
                }
            },
            buttons: {
                upload: {
                    text: 'Upload',
                    attributes: {
                        class: 'btn btn-form-submit'
                    }
                },
                cancel: {
                    text: 'Remove',
                    attributes: {
                        class: 'btn btn-form-cancel'
                    },
                    onClick:function(event, config) {
                        renumber();
                    }
                }
            },
            error: {
                selector: '[data-for-id=' + uploader.data('id') + '] [data-jq-upload-error]',
                attributes: {
                    style: 'margin:20px;padding:20px;border:1px solid #e51902; color:#e51902;border-radius:4px;'
                }
            },
            upload: {
                onError: function(event, config) {
                    alertify.error('Failed');
                },
                onSuccess: function(event, config) {
                    var baseElements = $(config.input).data('base-elements');
                    var templatesHtml = '';
                    var response = event.target.response;

                    for(var index in baseElements) {
                        var source = $('#'+baseElements[index].templateId).html();
                        var template = Handlebars.compile(source);
                        var context = {};

                        context[baseElements[index].name] = config.input.attr('id') + '[0][' + baseElements[index].name + ']';

                        var html = template(context);
                        templatesHtml += html;
                    }

                    if(templatesHtml) {
                        $(config.preview).find('button:last').after(templatesHtml);
                    }

                    if(typeof response !== 'undefined') {
                        response = JSON.parse(response);

                        if (typeof response.error !== 'undefined') {

                            alertify.error(response.error);
                            setTimeout(function() {
                                $('[data-jq-upload-button="cancel"]').trigger('click');
                            }, 500);
                            renumber();
                            return;
                        }

                        var files = response.files[0];
                        var file = files[0];

                        var inputHidden = document.createElement('input');
                        inputHidden.setAttribute('type', 'hidden');
                        inputHidden.setAttribute('name', config.input.attr('id') + '[0][file_id]');
                        inputHidden.setAttribute('style', 'display:none');
                        inputHidden.value = file.file_id;

                        $(config.preview).find('button:last').after(inputHidden);
                    }

                    renumber();

                    alertify.success('Success');
                }
            }
        };

        if ($(this).attr('multiple') === 'multiple') {
            options['buttons'].uploadAll = {
                text: 'Upload all files',
                attributes: {
                    class: 'btn btn-form-submit'
                }
            };
        }

        if(typeof $(this).data('auto-upload') !== 'undefined') {
            options['autoUpload'] = $(this).data('auto-upload');
        }

        if(typeof $(this).data('max-files') !== 'undefined') {
            options['maxFiles'] = $(this).data('max-files');
        }

        if(typeof $(this).data('extensions') !== 'undefined') {
            options['allowedExtensions'] = $(this).data('extensions');
        } else {
            options['allowedExtensions'] = ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'];
        }

        if(typeof $(this).data('mime-types') !== 'undefined') {
            options['allowedMimeTypes'] = $(this).data('mime-types');
        } else {
            options['allowedMimeTypes'] = ['image/jpeg', 'image/pjpeg', 'image/png'];
        }

        if(typeof $(this).data('timeout') !== 'undefined') {
            options['timeout'] = $(this).data('timeout');
        } else {
            options['timeout'] = 20000;
        }

        if(typeof $(this).data('preview-width') !== 'undefined') {
            options['preview']['width'] = $(this).data('preview-width');
            options['preview']['height'] = $(this).data('preview-height');
        } else {
            options['preview']['width'] = 400;
            options['preview']['height'] = 300;
        }

        if(typeof $(this).data('max-file-size') !== 'undefined') {
            options['maxFileSize'] = $(this).data('max-file-size');
        }

        uploader.upload(options);
    });
});