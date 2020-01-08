/*!

 =========================================================
 * Vue Paper Dashboard - v2.0.0
 =========================================================

 * Product Page: http://www.creative-tim.com/product/paper-dashboard
 * Copyright 2019 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE.md)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */
import Vue from "vue";
import App from "./App";
import router from "./router/index";
import store from './store/index'
import moment from 'moment'
import Paginate from 'vuejs-paginate'
import VueTruncate from 'vue-truncate-filter'
import Modal from './components/Modal.vue'
import vSelect from 'vue-select'
import Login from './components/Login.vue'

import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
Vue.use(VueSidebarMenu)


import PaperDashboard from "./plugins/paperDashboard";
import "vue-notifyjs/themes/default.css";
import Datetime  from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import 'vue-select/dist/vue-select.css';

Vue.component('paginate', Paginate)
Vue.use(PaperDashboard);
Vue.use(VueTruncate);
Vue.use(Datetime)

// filter qui permet de formater les dates
Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY')
  }
});

Vue.filter('truncate', function (value, size) {
  if (value) {
    return value.substr(0, size)+' ...';
  }else{
    return value
  }
});

Vue.component('modal', Modal)

Vue.component('v-select', vSelect)

Vue.mixin({
  methods: {
    notEmptyObject(someObject){
      return someObject ? Object.keys(someObject).length : 0
    },
    sayHello(){
    	console.log("hello ")
    }
  }
})


if(localStorage.getItem('userId')){
  /* eslint-disable no-new */
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
}else{
  new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Login)
  });
}