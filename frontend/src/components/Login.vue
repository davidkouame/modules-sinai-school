<template>
  <div class="container">
    <div class="row">
      <div class="offset-4 col-md-7">
        <h1 class="col-md-8" style="text-align: center; margin-bottom: 50px;">Connexion</h1>
        <div class="alert alert-danger col-md-8" v-show="errorMessage">{{ errorMessage }}</div>
        <form>
          <div class="form-group">
            <input
              type="email"
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
          <a type="submit" class="btn btn-primary col-md-8 active" v-on:click="connection">Connectez vous</a>
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
          localStorage.setItem("userId", response.data.data.id);
          localStorage.setItem("userName", response.data.data.name);
          localStorage.setItem("userEmail", response.data.data.email);
          localStorage.setItem("firstLogin", response.data.data.first_login);
          localStorage.setItem(
            "userType",
            this.getNameTypeUser(response.data.data)
          );
          localStorage.setItem(
            "professeurId",
            response.data.data.professeur_id
          );
          localStorage.setItem("parentId", response.data.data.parenteleve_id);
          localStorage.setItem("eleveId", response.data.data.eleve_id);

          localStorage.userId = response.data.data.id;
          localStorage.userName = response.data.data.name;
          localStorage.userEmail = response.data.data.email;
          localStorage.userType = this.getNameTypeUser(response.data.data);
          // localStorage.firstLogin = this.getNameTypeUser(response.data.data.first_login);
          console.log("=================="+localStorage.firstLogin);
          localStorage.professeurId = response.data.data.professeur_id;
          localStorage.parentId = response.data.data.parenteleve_id;
          localStorage.eleveId = response.data.data.eleve_id;
          window.location.reload();
        })
        .catch(response => {
          this.errorMessage = "Désolé, l'email ou le password est incorrect";
          console.log(response);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    getNameTypeUser(user) {
      let nameTypeUser = "";
      if (user.parenteleve_id) {
        nameTypeUser = "parent";
      } else if (user.professeur_id) {
        nameTypeUser = "professeur";
      } else if (user.eleve_id) {
        nameTypeUser = "eleve";
      }
      return nameTypeUser;
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
