import Vue from 'vue'
import './plugins/vuetify'
import i18n from './plugins/i18n'
import router from './router'
import 'es6-promise/auto'
import axios from 'axios'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import auth from './conf/auth'

import BootstrapVue from "bootstrap-vue"

import App from './App'

import Default from './Layout/Wrappers/baseLayout.vue'
import Pages from './Layout/Wrappers/pagesLayout.vue'
import Apps from './Layout/Wrappers/appLayout.vue'

// Set Vue globally
window.Vue = Vue
// Set Vue router
Vue.router = router
// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.VUE_APP_BASE_API}`
Vue.use(VueAuth, auth)
Vue.config.productionTip = false;

Vue.use(BootstrapVue);

Vue.component('default-layout', Default);
Vue.component('userpages-layout', Pages);
Vue.component('apps-layout', Apps);

new Vue({
  el: '#app',
  i18n,
  router,
  template: '<App/>',
  components: { App }
});
