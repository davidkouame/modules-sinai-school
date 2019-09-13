<template>
  <div class="container">
    <h1>Création de compte parent</h1>
    <div class="alert alert-danger" v-show="errorMessage">{{ errorMessage }}</div>
    <form action>
      <form>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" placeholder="Entrer un email" v-model="email" />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" placeholder="Password" v-model="password" />
        </div>
        <a type="submit" class="btn btn-primary" v-on:click="connection">Connectez vous</a>
      </form>
    </form>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "CreateCompteParent",
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
      this.$store
        .dispatch("loginParentEleve", { email, password })
        .then(response => {
          this.$router.push('/') 
        })
        .catch(response => {
          this.errorMessage = "Désolé, l'email ou le password est incorreect"
          console.log(response);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>