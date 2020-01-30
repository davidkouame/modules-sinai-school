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
              type="email"
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
                <!--<div class="col float-left">
                  <div class="form-check">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="exampleCheck1"
                      style="margin-left: -11px;"
                    />
                    <label class="form-check-label" for="exampleCheck1" style="padding-left: 13px;">Retenir le mot de passe</label>
                  </div>
                </div>-->
                <div class="col float-lfet" style="text-align: center"><a href="#">Mot de passe oublié ?</a></div>
              </div>
            </div>
          </div>
          <!--<a type="submit" class="btn btn-primary col-md-8 active" v-on:click="connection">Connectez vous</a>-->
          <div class="row">
            <button type="submit" class="btn btn-primary offset-md-2 col-md-8 active" v-show="!showLoader">Connectez vous</button>
            </br>
            <button class="btn btn-primary offset-md-2 col-md-8  active" type="submit" v-show="showLoader" style="color: #fff;background-color:
             #0062cc;border-color: #005cbf;opacity: 1;opacity: 0.8;color:#fff;background-color:#0062cc;border-color:#005cbf;
             cursor: default !important;" disabled>
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
        // console.log("chargement des années scolaires ")
        this.$store.dispatch('getAllAnneesScolaires', {page: 0});
    },
    computed: {
        anneesscolaires(){
            // console.log("liste des années scolaires "+JSON.stringify(this.anneesscolaires));
            return this.$store.getters.anneesscolaires;
        }
    },
  methods: {
    sub(event){
      event.preventDefault();
        alert("vdgsds");
    },
    connection(event) {
      this.showLoader = true;
      this.errorMessage = null;
      event.preventDefault();
      let email = this.email;
      let password = this.password;
      let store = this.$store;
      this.$store
        .dispatch("loginParentEleve", { email, password })
        .then(response => {
          this.$cookies.set("userId", response.data.data.id);
          this.$cookies.set("userName", response.data.data.name);
          this.$cookies.set("userSurname", response.data.data.surname);
          this.$cookies.set("userEmail", response.data.data.email);
          this.$cookies.set("firstLogin", response.data.data.first_login);
          this.$cookies.set(
            "userType",
            this.getNameTypeUser(response.data.data)
          );
          this.$cookies.set(
            "professeurId",
            response.data.data.professeur_id
          );
          this.$cookies.set("parentId", response.data.data.parenteleve_id);
          this.$cookies.set("eleveId", response.data.data.eleve_id);

          this.$cookies.set("userId", response.data.data.id);
          this.$cookies.set("userName", response.data.data.name);
          this.$cookies.set("userEmail", response.data.data.email);
          this.$cookies.set("userType", this.getNameTypeUser(response.data.data));
          this.$cookies.set("professeurId", response.data.data.professeur_id);
          this.$cookies.set("parentId", response.data.data.parenteleve_id);
          this.$cookies.set("eleveId", response.data.data.eleve_id);




          this.loadSessionUser(response.data.data.id);
        })
        .catch(response => {
          this.errorMessage = "Désolé, l'email ou le password est incorrect";
          this.showLoader = false;
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
    },
    loadSessionUser(user_id){
        this.$store
        .dispatch("sessionuserappSync", {user_id: user_id})
        .then(response => {
          // console.log("response =>"+JSON.stringify(response.data.data[0].annee_scolaire_id));
          if(response.data.data){
            // console.log("l'utilisateur a une session");
            this.$cookies.set("anneeScolaireId", response.data.data[0].annee_scolaire_id);
          }else{
            if(this.anneesscolaires){
              // recuperation de la premiere année scolaire 
              let anneeScolaireId = this.anneesscolaires[(this.anneesscolaires.length-1)].id;
              this.$cookies.set("anneeScolaireId", anneeScolaireId);
              this.$store.dispatch('anneeScolaireId', anneeScolaireId);
              let dataSa = null;
              let data = {annee_scolaire_id: anneeScolaireId, user_id: user_id};
              dataSa = {data: data};
              let store = this.$store;
              store.dispatch("saveSessionUserApp", dataSa);
            }
          }
          window.location.reload();
        })
        .catch(response => {
          // this.errorMessage = "Désolé, l'email ou le password est incorrect";
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
