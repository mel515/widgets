window.Admin.vue.stores['widgets-package_widgets'] = new Vuex.Store({
  state: {
    emptyWidget: {
      model: {
        view: '',
        params: {},
        additional_info: {},
        created_at: null,
        updated_at: null,
        deleted_at: null
      },
      isModified: false,
      hash: '',
    },
    widget: {},
    mode: '',
  },
  mutations: {
    setWidget(state, widget) {
      let emptyWidget = JSON.parse(JSON.stringify(state.emptyWidget));
      emptyWidget.model.id = UUID.generate();

      let resultWidget = _.merge(emptyWidget, widget);
      resultWidget.hash = window.hash(resultWidget.model);

      state.widget = resultWidget;
    },
    setMode(state, mode) {
      state.mode = mode;
    }
  }
});
