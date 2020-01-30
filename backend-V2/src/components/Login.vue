<template>
  <div class="container">
    <div>
      <h1 class="col-md-12" style="padding-left: 31%; margin-top: 54px;">Bienvenue à Ayauka !</h1>
    </div>
    <div class="row">
      <div class="login">
        <h2 class="col-md-12" style="text-align: center; margin-bottom: 24px;">Connexion</h2>
        <div class="alert alert-danger col-md-12" v-show="errorMessage">{{ errorMessage }}</div>
        <form v-on:submit="connection" >
          <div class="form-group">
            <input
              type="text"
              class="form-control col-md-12"
              placeholder="Entrer un email"
              v-model="email"
            />
          </div>
          <div class="form-group">
            <input
              type="password"
              class="form-control col-md-12"
              placeholder="Password"
              v-model="password"
            />
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <div class="row">
                <div class="col float-lfet" style="text-align: center"><a href="#">Mot de passe oublié ?</a></div>
              </div>
            </div>
          </div>
          <div class="row">
            <button type="submit" class="btn btn-primary offset-md-2 col-md-8 active" v-if="!showLoader">Connectez vous</button>
            </br>
            <button class="btn btn-primary offset-md-2 col-md-8  active" type="submit" v-if="showLoader" style="color: #fff;background-color:
             #0062cc;border-color: #005cbf;opacity: 1;opacity: 0.8;color:#fff;background-color:#0062cc;border-color:#005cbf;
             cursor: default !important;">
             <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
              <span class="sr-only">Loading...</span>
             Connectez vous
              <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
              <span class="sr-only">Loading...</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
      showLoader: false
    };
  },
    created(){
        // this.$store.dispatch('anneesscolaires');
        if(this.$cookies.get('userId')){
          this.$router.push('/') 
        }
    },
    computed: {
        anneesscolaires(){
            return this.$store.getters.anneesscolaires;
        }
    },
  methods: {
    sub(event){
      event.preventDefault();
        alert("vdgsds");
    },
    connection(event) {
      event.preventDefault();
      this.showLoader = true;
      let email = this.email;
      let password = this.password;
      let store = this.$store;
      this.$store
        .dispatch("login", { email, password })
        .then(response => {
          this.$cookies.set("userId", response.data.data.id);
          this.$cookies.set("userName", response.data.data.name);
          this.$cookies.set("userSurname", response.data.data.surname);
          this.$cookies.set("userEmail", response.data.data.email);
          this.$cookies.set("firstLogin", response.data.data.first_login);
          window.location.reload();
        })
        .catch(response => {
          this.errorMessage = "Désolé, l'email ou le password est incorrect";
          console.log(response);
          this.showLoader = false;
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>

<style>

body{
  background: #ebebeb !important
}

input[type=text]{
  height: 54px!important;
}

.label-checkbox100 {
  font-family: Ubuntu-Regular;
  font-size: 16px;
  color: #999;
  line-height: 1.2;
  display: block;
  position: relative;
  padding-left: 26px;
  cursor: pointer;
}

.input-checkbox100 {
  display: none;
}

.form-check input[type="checkbox"],
.form-check-radio input[type="radio"] {
  opacity: 1;
  position: absolute;
  visibility: visible;
}


::placeholder {
  font-size: 20px;
}

input[type=text]{
  height: 54px!important;
}

.label-checkbox100 {
  font-family: Ubuntu-Regular;
  font-size: 16px;
  color: #999;
  line-height: 1.2;
  display: block;
  position: relative;
  padding-left: 26px;
  cursor: pointer;
}

.input-checkbox100 {
  display: none;
}

.form-check input[type="checkbox"],
.form-check-radio input[type="radio"] {
  opacity: 1;
  position: absolute;
  visibility: visible;
}


::placeholder {
  font-size: 20px;
}

body{
  background-color : #ebebeb;
}

.login{
  width: 520px;
background:
#fff;
border-radius: 10px;
position: relative;
padding-right: 85px;
padding-left: 85px;
padding-bottom: 55px;
padding-top: 16px;
    margin-top: 10px;
    margin-left: 30%
}
</style>

