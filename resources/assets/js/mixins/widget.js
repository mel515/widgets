window.Admin.vue.mixins['widget'] = {
    props: {
        widget: {
            type: Object,
            default() {
                return {
                    events: {}
                };
            }
        },
    },
    data: function () {
        return {
            model: this.getDefaultWidgetModel(),
            options: {
                loading: false
            },
            events: _.merge({
                widgetLoaded: function () {},
                widgetSaved: function () {}
            }, this.widget.events)
        };
    },
    watch: {
        'model.id': {
            handler: function (newVal, oldVal) {
                if (newVal && newVal !== oldVal) {
                    this.getWidget();
                }
            },
            immediate: true
        }
    },
    methods: {
        getDefaultWidgetModel() {
            return {
                id: 0,
                view: '',
                params: {},
                additional_info: {},
                created_at: null,
                updated_at: null,
                deleted_at: null
            };
        },
        getWidget: function () {
            let component = this;

            let url = route('back.widgets.show', component.model.id);

            component.options.loading = true;

            axios.get(url).then(response => {
                component.model = response.data;
                component.options.loading = false;

                component.events.widgetLoaded(component);
            })
            .catch(error => {
                swal({
                    title: "Ошибка",
                    text: "Произошла ошибка при получении виджета",
                    type: "error"
                });
            });
        },
        saveWidget() {
            let component = this;

            let callback = (0 in arguments) ? arguments[0] : undefined;

            let url = (component.model.id !== 0) ? route('back.widgets.update', component.model.id): route('back.widgets.store');

            let data = JSON.parse(JSON.stringify(component.model));
            if (component.model.id !== 0) {
                data._method = 'PUT';
            }

            component.options.loading = true;

            axios.post(url, data).then(response => {
                component.model = response.data;
                component.options.loading = false;

                component.events.widgetSaved(component.model);

                if (typeof callback !== 'undefined') {
                    callback(component.model);
                }
            });
        }
    }
};
