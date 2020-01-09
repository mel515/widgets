window.tinymce.PluginManager.add('widgets', function (editor) {
    let widgetData = {
        widget: {
            events: {
                widgetSaved: function(model) {
                    editor.execCommand(
                        'mceReplaceContent',
                        false,
                        '<img class="content-widget" data-type="embedded" data-id="' + model.id + '" alt="Виджет-код" />',
                    );
                },
            },
        },
    };

    function initComponents() {
        if (typeof window.Admin.vue.modulesComponents.$refs['widgets-package_EmbeddedWidget'] == 'undefined') {
            window.Admin.vue.modulesComponents.modules['widgets-package'].components = _.union(
                window.Admin.vue.modulesComponents.modules['widgets-package'].components, [
                    {
                        name: 'EmbeddedWidget',
                        data: widgetData,
                    },
                ]);
        } else {
            let component = window.Admin.vue.modulesComponents.$refs['widgets-package_EmbeddedWidget'][0];

            component.$data.model.id = widgetData.model.id;
        }
    }
    
    editor.addButton('add_embedded_widget', {
        title: 'Встраиваемый код',
        icon: 'codesample',
        onclick: function () {
            editor.focus();

            let content = editor.selection.getContent();
            let isEmbedded = /<img class="content-widget".+data-type="embedded".+>/g.test(content);

            if (content === '' || isEmbedded) {
                widgetData.model = {
                    id: parseInt($(content).attr('data-id')) || 0,
                };

                initComponents();

                window.waitForElement('#add_embedded_widget_modal', function() {
                    $('#add_embedded_widget_modal').modal();
                });
            } else {
                swal({
                    title: 'Ошибка',
                    text: 'Необходимо выбрать виджет-код',
                    type: 'error',
                });

                return false;
            }
        }
    })
});
