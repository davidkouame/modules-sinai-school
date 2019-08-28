// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

Vue.config.productionTip = false

/* eslint-disable no-new */
/*new Vue({
  data () {
    return {
      greeting: 'dfbhdsbfhsd fsdhfsd fdsf sdhfsdf dsf fjfjfjf',
      dynamicId: 'dynamicId',
      id: 'id',
      num1: 100,
      num2: 200,
      total: '',
      personne: {
        nom: '',
        prenom: ''
      },
      isAuth: false,
    }
  },
  created () {
    console.log("Nous sommes dans la function de création !");
    // performAuth().then(auth => this.isAuth = auth.username ? true : false)
  },
  methods: {
    displaynumbers (event) {
      console.log(event);
      return this.total = this.num1 + this.num2;
    },
    handleFormSubmit () {
      // event.preventDefault();
      // Send data to the server or update your stores and such.
      console.log("nous sommes pret pour l'envoi du formulaire");
    }
  }
}).$mount('#app')*/
new Vue({
  el: '#app',
  // store,
  router, // Ignore for now
  template: '<App/>',
  components: { App },
});
