<template>
  <div class="container">
    <div class="row">
      <div class="offset-4 col-md-7">
        <h1 class="col-md-8" style="text-align: center; margin-bottom: 50px;">Changer votre mot de passse</h1>
        <div class="alert alert-danger col-md-8" v-show="errorMessage">{{ errorMessage }}</div>
        <form>
          <div class="form-group">
            <input
              type="password"
              class="form-control col-md-8"
              placeholder="Password"
              v-model="password_confirmation"
            />
          </div>
          <div class="form-group">
            <input
              type="password"
              class="form-control col-md-8"
              placeholder="Retype Password"
              v-model="password"
            />
          </div>
          <a type="submit" class="btn btn-primary col-md-8 active" v-on:click="connection">Confirmez</a>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "FirstConnexion",
  data() {
    return {
      email: "",
      password: "",
      password_confirmation: "",
      errorMessage: ""
    };
  },
  methods: {
    connection() {
      const data = new FormData();
     
      data.append("email", this.$cookies.get("userEmail"));
       /*data.append("username", this.$cookies.get("userName"));
      data.append("password", this.password);
      data.append("password_confirmation", this.password_confirmation);
      data.append("password_confirmation", this.password_confirmation);*/
      data.append("first_login", 1);
      this.$store
        .dispatch("updateUser", data)
        .then(response => {
          alert("modificaion réussite avec succes");
          this.$cookies.set("firstLogin", 1);
          window.location.reload();
        })
        .catch(response => {
          this.errorMessage = "Désolé, les mots de passes ne correspondent pas !";
          console.log(response);
          this.errored = true;
        });
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
