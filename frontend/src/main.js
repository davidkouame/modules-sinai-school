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
// import ParentLayout from './components/layouts/Parent.vue'
// import EleveLayout from './components/layouts/Eleve.vue'
// import ProfesseurLayout from './components/layouts/Professeur.vue'
import Login from './components/Login.vue'
import FirstConnexion from './components/FirstConnexion.vue'
import BootstrapVue from 'bootstrap-vue'
import Paginate from 'vuejs-paginate'
import Modal from './components/Modal.vue'
import DashboardLayout from './layout/DashboardLayout.vue'
import EleveLayout from './layout/EleveLayout.vue'
import ParentLayout from './layout/ParentLayout.vue'
import ProfesseurLayout from './layout/ProfesseurLayout.vue'
import moment from 'moment'
import MessageErrorCpt from "./components/Plugin/MessageErrorCpt";
Vue.use(MessageErrorCpt)
Vue.component("message-error", MessageErrorCpt);

import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

import VueRouteMiddleware from 'vue-route-middleware';

Vue.use(Datetime)

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

// set default config
Vue.$cookies.config('7d')

// set global cookie
Vue.$cookies.set('theme','default');
Vue.$cookies.set('hover-time','1s');


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
});

router.beforeEach(VueRouteMiddleware());

/* eslint-disable no-new */
/*new Vue({
  el: '#app',
  render: h => h(App),
  router
})*/

Vue.mixin({
  methods: {
    notEmptyObject(someObject) {
      return someObject ? Object.keys(someObject).length : 0
    },
    traitError(error) {
      let errors = Object.values(error);
      let messageErrors = "";
      // recuperation de la reponse
      if (errors[1]) {
        let reponse = errors[1].response;
        if (JSON.parse(reponse)) {
          // recuperation des erreurs
          let dataErrors = JSON.parse(reponse).data;
          let i = 0;
          const keys = Object.keys(dataErrors);
          const values = Object.values(dataErrors);
          for (const value of values) {
            let fields = value.values();
            for (const field of fields) {
              messageErrors += field + "</br>";
            }
          }
        }
      }
      return messageErrors;
    }
  }
})

Vue.config.productionTip = false

Vue.use(BootstrapVue)

Vue.component('paginate', Paginate)

Vue.component('modal', Modal)

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY')
  }
});

Vue.filter('formatMoyenne', function (value) {
  if (value) {
    let valeurs = value.split(".");
    let decimal = null;
    if(valeurs[1]){
      if(valeurs[1].length == 1){
        decimal = valeurs[1]+"0";
      }else if(valeurs[1].length > 2){
        decimal = str.substr(0, 2);
      }
    }else{
      decimal = "00";
    }
    return valeurs[1]+"."+decimal;
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

/*

let vue = null;
if (cookies.get('userId')) {
  if (cookies.get('firstLogin') == 0) {
    vue = {
      el: '#app',
      router,
      store,
      components: { FirstConnexion },
      template: '<FirstConnexion/>'
    };
  }else{
    if (cookies.get('userType') == "parent") {
    vue = {
      el: '#app',
      router,
      store,
      components: { ParentLayout },
      template: '<ParentLayout/>'
    };
  } else if(cookies.get('userType') == "professeur"){
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

// eslint-disable
new Vue(vue);
*/

const cookies = Vue.prototype.$cookies;

/* eslint-disable no-new */
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");

