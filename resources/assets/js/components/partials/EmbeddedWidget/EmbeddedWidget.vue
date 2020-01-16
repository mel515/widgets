<template>
    <div id="add_embedded_widget_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Вставьте код</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-wysiwyg
                            label = "Код"
                            name = "embedded_code"
                            v-bind:value.sync="model.params.code"
                            v-bind:simple = true
                            v-bind:attributes = "{
                                'id': 'embedded_code',
                                'cols': '50',
                                'rows': '10',
                            }"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'EmbeddedWidget',
    data() {
      return {
        model: this.getDefaultModel(),
        options: {
          loading: true,
        },
        events: {
          widgetLoaded: function(component) {
            window.tinymce.get('embedded_code').setContent(component.model.params.code);
          },
        },
      };
    },
    computed: {
      modalWidgetState() {
        return window.Admin.vue.stores['widgets-package_widgets'].state.mode;
      },
    },
    watch: {
      modalWidgetState: function(newMode) {
        if (newMode === 'widget_created') {
          let widget = window.Admin.vue.stores['widgets-package_widgets'].state.widget;

          this.model.params.id = widget.model.id;

          this.save();
        }
      },
    },
    methods: {
      getDefaultModel() {
        return _.merge(this.getDefaultWidgetModel(), {
          view: 'admin.module.widgets::front.partials.content.embedded_widget'
        });
      },
      initComponent() {
        let component = this;

        component.model = _.merge(component.model, this.widget.model);
        component.options.loading = false;
      },
      save() {
        let component = this;

        if (_.get(component.model.params, 'code', '') === '') {
          $(component.$refs.modal).modal('hide');

          return;
        }

        component.saveWidget(function() {
          $(component.$refs.modal).modal('hide');
        });
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.model = component.getDefaultModel();
          window.tinymce.get('embedded_code').setContent('');
        });
      });
    },
    mixins: [
      window.Admin.vue.mixins['widget'],
    ],
  };
</script>
