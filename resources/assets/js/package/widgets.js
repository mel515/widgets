window.Admin = window.Admin || {
    options: {
        tinymce: {}
    }
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
