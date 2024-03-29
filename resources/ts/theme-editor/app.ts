import Vue from "vue";
import VueCompositionAPI from "@vue/composition-api";
import { createPinia, PiniaVuePlugin } from "pinia";
import { ColorPicker, ColorPanel } from "one-colorpicker";

import mdiVue from "mdi-vue/v2";
import * as mdijs from "@mdi/js";

import App from "./App.vue";
import router from "./router";

Vue.use(PiniaVuePlugin);
Vue.use(VueCompositionAPI);
Vue.use(mdiVue, {
  icons: mdijs,
});
Vue.use(ColorPicker);
Vue.use(ColorPanel);

Vue.config.productionTip = false;

const pinia = createPinia();

new Vue({
  pinia,
  router,
  render: (h) => h(App),
}).$mount("#app");
