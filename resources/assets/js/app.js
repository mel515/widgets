require('./plugins/tinymce/plugins/widgets');

require('./mixins/widget');

require('./stores/widgets');

Vue.component(
    'EmbeddedWidget',
    require('./components/partials/EmbeddedWidget/EmbeddedWidget.vue').default,
);

let widgets = require('./package/widgets');
widgets.init();
