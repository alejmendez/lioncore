/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import App from './App.vue'

// Vuesax Component Framework
//import Vuesax from 'vuesax'
//Vue.use(Vuesax)

// Theme Configurations
import '../themeConfig.js'

// axios
import axios from './axios.js'
Vue.prototype.$http = axios

// API Calls
import './http/requests'

// Firebase
import '@/firebase/firebaseConfig'

// Auth0 Plugin
import AuthPlugin from './plugins/auth'
Vue.use(AuthPlugin)

// ACL
import acl from './acl/acl'

// Globally Registered Components
import './globalComponents.js'

// Vuex Store
import store from './store/store'

// Vue Router
import router from './router/index'

// i18n
import i18n from './i18n/i18n'


// Vuexy Admin Filters
import './filters/filters'


// VeeValidate
import './plugins/validator'

// Vuejs - Vue wrapper for hammerjs
import { VueHammer } from 'vue2-hammer'
Vue.use(VueHammer)

// PrismJS
import 'prismjs'
import 'prismjs/themes/prism-tomorrow.css'


// Feather font icon
require('@assets/css/iconfont.css')


// Vue select css
// Note: In latest version you have to add it separately
// import 'vue-select/dist/vue-select.css';

Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
