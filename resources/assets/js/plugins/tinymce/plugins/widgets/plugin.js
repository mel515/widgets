window.tinymce.PluginManager.add('widgets', function (editor) {
    editor.addButton('add_embedded_widget', {
        title: 'Встраиваемый код',
        icon: 'codesample',
        onclick: function () {
            editor.focus();

            let content = editor.selection.getContent();
            initTinyMCE('#embedded_code_modal');
            let widgetID = '';

            if (content !== '' && ! /<img class="content-widget".+data-type="embedded".+\/>/g.test(content)) {
                swal({
                    title: "Ошибка",
                    text: "Необходимо выбрать виджет-код",
                    type: "error"
                });

                return false;
            } else if (content !== '') {
                widgetID = $(content).attr('data-id');

                window.Admin.modules.widgets.getWidget(widgetID, function (widget) {
                    window.tinymce.get('embedded_code').setContent(widget.params.code);
                });
            }

            $('#embedded_code_modal .save').off('click');
            $('#embedded_code_modal .save').on('click', function (event) {
                event.preventDefault();

                let code = window.tinymce.get('embedded_code').getContent();

                window.Admin.modules.widgets.saveWidget(widgetID, {
                    view: 'admin.module.widgets::front.partials.content.embedded_widget',
                    params: {
                        code: code
                    }
                }, {
                    editor: editor,
                    type: 'embedded',
                    alt: 'Виджет-код'
                }, function (widget) {
                    $('#embedded_code_modal').modal('hide');
                });
            });

            $('#embedded_code_modal').modal();
        }
    })
});
