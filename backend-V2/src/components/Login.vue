<template>
  <div class="container">
    <div class="row">
      <div class="offset-4 col-md-7">
        <h1 class="col-md-8" style="text-align: center; margin-bottom: 50px;">Connexion</h1>
        <div class="alert alert-danger col-md-8" v-show="errorMessage">{{ errorMessage }}</div>
        <form v-on:submit="connection" >
          <div class="form-group">
            <input
              type="text"
              class="form-control col-md-8"
              placeholder="Entrer un email"
              v-model="email"
            />
          </div>
          <div class="form-group">
            <input
              type="password"
              class="form-control col-md-8"
              placeholder="Password"
              v-model="password"
            />
          </div>
          <div class="form-group">
            <div class="col-md-8">
              <div class="row">
                <div class="col float-left">
                  <div class="form-check">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="exampleCheck1"
                      style="margin-left: -11px;"
                    />
                    <label class="form-check-label" for="exampleCheck1" style="padding-left: 13px;">Retenir le mot de passe</label>
                  </div>
                </div>
                <div class="col float-right"><a href="#">Mot de passe oublié ?</a></div>
              </div>
            </div>
          </div>
          <!--<a type="submit" class="btn btn-primary col-md-8 active" v-on:click="connection">Connectez vous</a>-->
          <button type="submit" class="btn btn-primary col-md-8 active">Connectez vous</button>
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
      
    };
  },
    created(){
        // this.$store.dispatch('anneesscolaires');
        if(localStorage.getItem('userId')){
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
      let email = this.email;
      let password = this.password;
      let store = this.$store;
      this.$store
        .dispatch("login", { email, password })
        .then(response => {
          localStorage.setItem("userId", response.data.data.id);
          localStorage.setItem("userName", response.data.data.name);
          localStorage.setItem("userSurname", response.data.data.surname);
          localStorage.setItem("userEmail", response.data.data.email);
          localStorage.setItem("firstLogin", response.data.data.first_login);
           window.location.reload();
        })
        .catch(response => {
          this.errorMessage = "Désolé, l'email ou le password est incorrect";
          console.log(response);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>

<style>
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
</style>
