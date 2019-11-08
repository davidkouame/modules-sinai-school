/*!

 =========================================================
 * Vue Light Bootstrap Dashboard - v2.0.0 (Bootstrap 4)
 =========================================================

 * Product Page: http://www.creative-tim.com/product/light-bootstrap-dashboard
 * Copyright 2019 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE.md)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'

// LightBootstrap plugin
import LightBootstrap from './light-bootstrap-main'

// router setup
import routes from './routes/routes'

import './registerServiceWorker'

import store from './store/index'
import ParentLayout from './components/layouts/Parent.vue'
// import EleveLayout from './components/layouts/Eleve.vue'
import ProfesseurLayout from './components/layouts/Professeur.vue'
import Login from './components/Login.vue'
import BootstrapVue from 'bootstrap-vue'
import Paginate from 'vuejs-paginate'
import Modal from './components/Modal.vue'
import DashboardLayout from './layout/DashboardLayout.vue'
import EleveLayout from './layout/EleveLayout.vue'
import moment from 'moment'

// plugin setup
Vue.use(VueRouter)
Vue.use(LightBootstrap)

// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkActiveClass: 'nav-item active',
  scrollBehavior: (to) => {
    if (to.hash) {
      return {selector: to.hash}
    } else {
      return { x: 0, y: 0 }
    }
  }
})

/* eslint-disable no-new */
/*new Vue({
  el: '#app',
  render: h => h(App),
  router
})*/

Vue.config.productionTip = false

Vue.use(BootstrapVue)

Vue.component('paginate', Paginate)

Vue.component('modal', Modal)

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('MM/DD/YYYY')
  }
});

Vue.filter('truncate', function (value) {
  return value.substring(0, 20)
});

Vue.mixin({
  data: function() {
    return {
      generalClasseId: null
    }
  }
});

let vue = null;
if (localStorage.getItem('userId')) {
  if (localStorage.getItem('userType') == "parent") {
    vue = {
      el: '#app',
      router,
      store,
      components: { ParentLayout },
      template: '<ParentLayout/>'
    };
  } else if(localStorage.getItem('userType') == "professeur"){
    vue = {
      el: '#app',
      router,
      store,
      components: { ProfesseurLayout },
      template: '<ProfesseurLayout/>'
    };
  }else {
    vue = {
      el: '#app',
      router,
      store,
      components: { EleveLayout },
      template: '<EleveLayout/>'
    };
  }
} else {
  vue = {
    el: '#app',
    router,
    store,
    components: { Login },
    template: '<Login/>'
  };
}

/* eslint-disable */
new Vue(vue);

