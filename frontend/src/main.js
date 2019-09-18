// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Vuex from 'vuex'
import App from './App'
import Login from './components/Login.vue'
import ParentLayout from './components/layouts/Parent.vue'
import EleveLayout from './components/layouts/Eleve.vue'
import ProfesseurLayout from './components/layouts/Professeur.vue'
import router from './router'
import moment from 'moment'
import 'bootstrap'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Axios from 'axios'
import Paginate from 'vuejs-paginate'
import store from './store/index'
import VuePaginationfrom from './components/Pagination.vue'

/* axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}; */

Vue.config.productionTip = false

Vue.use(BootstrapVue)

Vue.component('paginate', Paginate)

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('MM/DD/YYYY')
  }
});

Vue.filter('truncate', function (value) {
  return value.substring(0, 20)
});


if (localStorage.userId) {
  if (localStorage.userType == "parent") {
    /* eslint-disable */
    new Vue({
      el: '#app',
      router,
      store,
      components: { ParentLayout },
      template: '<ParentLayout/>'
    })
  } else if(localStorage.userType == "professeur"){
    /* eslint-disable */
    new Vue({
      el: '#app',
      router,
      store,
      components: { ProfesseurLayout },
      template: '<ProfesseurLayout/>'
    })
  }else {
    /* eslint-disable */
    new Vue({
      el: '#app',
      router,
      store,
      components: { EleveLayout },
      template: '<EleveLayout/>'
    })
  }

} else {
  /* eslint-disable */
  new Vue({
    el: '#app',
    router,
    store,
    components: { Login },
    template: '<Login/>'
  })
}


