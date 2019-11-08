<template>
  <div class="container">
    <h1>Connexion</h1>
    <div class="alert alert-danger" v-show="errorMessage">{{ errorMessage }}</div>
    <form action>
      <form>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" placeholder="Entrer un email" v-model="email">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" placeholder="Password" v-model="password">
        </div>
        <a type="submit" class="btn btn-primary" v-on:click="connection">Connectez vous</a>
      </form>
    </form>
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
      errorMessage: ""
    };
  },
  methods: {
    connection() {
      let email = this.email;
      let password = this.password;
      let store = this.$store;
      this.$store
        .dispatch("loginParentEleve", { email, password })
        .then(response => {
          localStorage.setItem('userId', response.data.data.id);
          localStorage.setItem('userName', response.data.data.name);
          localStorage.setItem('userEmail', response.data.data.email);
          localStorage.setItem('userType', this.getNameTypeUser(response.data.data));
          localStorage.setItem('professeurId', response.data.data.professeur_id);
          localStorage.setItem('parentId', response.data.data.parenteleve_id);
          localStorage.setItem('eleveId', response.data.data.eleve_id);


          localStorage.userId = response.data.data.id;
          localStorage.userName = response.data.data.name;
          localStorage.userEmail = response.data.data.email;
          localStorage.userType  = this.getNameTypeUser(response.data.data);
          localStorage.professeurId = response.data.data.professeur_id;
          localStorage.parentId = response.data.data.parenteleve_id;
          localStorage.eleveId = response.data.data.eleve_id;
          window.location.reload();
        })
        .catch(response => {
          this.errorMessage = "Désolé, l'email ou le password est incorreect";
          console.log(response);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    getNameTypeUser(user){
      let nameTypeUser = "";
      if(user.parenteleve_id){
        nameTypeUser = "parent";
      }else if(user.professeur_id){
        nameTypeUser = "professeur";
      }else if(user.eleve_id){
        nameTypeUser = "eleve";
      }
      return nameTypeUser;
    }
  }
};
</script>
