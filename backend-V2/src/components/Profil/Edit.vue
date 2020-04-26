<template>
  <card class="card" :title="title">
    <div class="row">
      <!-- Show error message -->
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

      <div class="col-md-12" v-if="school">
        <form v-on:submit="saveSchoolParam">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Nom et prénom</label>
                <input class="form-control" v-model="school.username"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Email</label>
                <input class="form-control" disabled  v-model="school.email"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Password</label>
                <input type="password" class="form-control" v-model="password"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Confirmer le password</label>
                <input type="password" class="form-control" v-model="confirmationpassword"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Année scolaire</label>
                <!---->
                <select class="form-control" v-model="anneescolaire">
                  <!--<option value>Sélectionnez une année scolaire</option>-->
                  <option
                    :value="anneescolaire.id"
                    v-for="anneescolaire in anneesscolaires"
                  >{{ anneescolaire.libelle }}</option>
                </select>
                <!---->
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <div class="float-right">
            <div class="row">
              <div class="col-md-12">
                <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a>
                &nbsp;
                <button
                  type="submit"
                  class="btn btn-primary btn-add"
                  :disabled="valueDisabled"
                >
                  Modifier
                  <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div>
                </button>
                &nbsp;
                  <a @click="validateAnneeScolaire" class="btn btn-primary btn-add" v-if="isValidate()">Valider l'année scolaire</a>
                  <a href="javascript:void(0)" class="btn btn-primary btn-add" disabled v-else>Valider l'année scolaire</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </card>
</template>

<script>
import moment from "moment";

export default {
  data() {
    return {
      title: "Profil",
      isLoader: false,
      valueDisabled: false,
      error: null,
      anneescolaire: null,
      password: null,
      confirmationpassword: null
    };
  },
  created() {
    // recuperation des années scolaires
    this.dispatchAnnneesScolaires();
    // recuperation des informations de l'admin de l'école
    this.$store.dispatch("getSchool",{schoolId: this.$cookies.get('ecoleId')});

  },
  methods: {
    dispatchAnnneesScolaires(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "search", value: search },
        { key: "school_id", value: this.$cookies.get("ecoleId") }
      ];
      this.$store.dispatch("getAnneesScolairesBySchoolId", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    trimSearch(searchs = null) {
      let params = [];
      for (var key in searchs) {
        // console.log("type of "+typeof searchs[key].value)
        if (searchs[key].value) {
          params.push({ key: searchs[key].key, value: searchs[key].value });
        }
      }
      return params;
    },
    saveSchoolParam() {
      this.valueDisabled = true;
      let data = {
        username: this.school.username,
        password: this.password,
        confirmationpassword: this.confirmationpassword
      };
      let store = this.$store;
      store
        .dispatch("updateSchoolCustomise", {
          data: data,
          id: this.$cookies.get("ecoleId")
        })
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès");
          this.$cookies.set("anneeScolaireId", this.anneescolaire);
          window.location.reload();
        })
        .catch(error => {
          this.error = error;
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    },
    validateAnneeScolaire(){
      let store = this.$store;
      store
        .dispatch("validateModel", {"url": "anneesscolaires", "data": {school_id: this.$cookies.get('ecoleId')}, "id": this.anneescolaire})
        .then(response => {
          alert("L'année scolaire a été validé avec succès !");
          window.location.reload();
        })
        .catch(error => {
          console.log(error);
          alert("Echec lors de la validation")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    isValidate(){
      let validate = false
      if(this.anneesscolaires && this.anneescolaire){
        let validated_at = this.getAnneeScolaire(this.anneescolaire).validated_at;
        validate = validated_at && validated_at.length > 0 ? false : true; 
        console.log(validate);
      }
      return validate;
    },
    getAnneeScolaire(anneeScolaireId){
      let t = null;
      this.anneesscolaires.forEach(element => {
          if(element.id == anneeScolaireId){
            t = element;
          }
        });
      return t;
    }
  },
  computed: {
    abonnement() {
      return this.$store.getters.abonnement;
    },
    anneesscolaires() {
      return this.$store.getters.anneesscolaires;
    },
    packsabonnement() {
      return this.$store.getters.packsabonnement;
    },
    parents() {
      return this.$store.getters.parents;
    },
    eleve() {
      return this.$store.getters.chooseEleve;
    },
    showEmptySentenceAbonnement() {
      return this.notEmptyObject(this.eleves) == 0;
    },
    elevesComputed() {
      return this.$store.getters.elevesabonnement;
    },
    anneesscolaires() {
      return this.$store.getters.anneesscolaires;
    },
    school(){
      return this.$store.getters.school;
    }
  },
  watch: {
    school() {
      this.anneescolaire = this.$cookies.get('anneeScolaireId');
      if(!this.anneescolaire && this.anneesscolaires){
        console.log("nous sommes dans la fonction d'assignation de l'année scolaire ");
        this.anneescolaire = this.anneesscolaires[0].id;
      } 
    },
    anneesscolaires(){
      this.anneescolaire = this.$cookies.get('anneeScolaireId');
      if(!this.anneesscolaires && this.anneescolaire){
        this.anneescolaire = this.anneesscolaires[0].id;
      }
    },
    elevesComputed(){
      if (this.elevesComputed && !this.isLoader) {
        var i = 0;
        for (i = 0; i < this.elevesComputed.length; i++) {
          this.eleves.push(this.elevesComputed[i]);
        }
        this.isLoader = true;
      }
    }
  }
};
</script>
