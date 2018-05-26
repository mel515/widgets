window.Admin = window.Admin || {
    options: {
        tinymce: {}
    },
    modules: {}
};

$.extend(window.Admin.options.tinymce, {
    init_instance_callback: function (editor) {
        editor.on('change redo undo', function (e) {
            let content = $(editor.getContent()),
                widgets = content.find('.content-widget');

            $('input[name=widgets]').val(widgets.map(function () {
                    return $(this).attr('data-id');
                }).get()
            );
        });
    }
});

$.extend(window.Admin.modules, {
    widgets: {
        getWidget: function (widgetID, callback) {
            $.ajax({
                url: route('back.widgets.show', widgetID),
                method: 'GET',
                dataType: 'json',
                success: function (widget) {
                    callback(widget);
                },
                error: function () {
                    swal({
                        title: "Ошибка",
                        text: "Произошла ошибка при получении виджета",
                        type: "error"
                    });
                }
            });
        },
        saveWidget: function (widgetID, widgetData, widgetOptions) {
            let url = (widgetID !== '') ? route('back.widgets.update', widgetID): route('back.widgets.store');

            if (widgetID !== '') {
                $.extend(widgetData, {
                    _method: 'PUT'
                })
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: widgetData,
                dataType: 'json',
                success: function (widget) {
                    widgetOptions.editor.execCommand('mceReplaceContent', false, '<img class="content-widget" data-type="'+widgetOptions.type+'" data-id="'+widget.id+'" alt="'+widgetOptions.alt+'" style="height: 100px; width: 100%; border: 1px red solid;" />');
                }
            });
        }
    }
});
