<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

        <div class="col-md-12" v-if="professeur">
          <form v-on:submit="saveProfesseur">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.nom"
                        placeholder="Nom"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Prénom (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.prenom"
                        placeholder="Prénom"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Email (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="email"
                        v-model="professeur.email"
                        placeholder="Email"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Téléphone (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.tel"
                        placeholder="Téléphone"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matière</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.matiere"
                        placeholder="Matière"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.reference"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="professeur.description"></textarea>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row form-group">
                      <label class="col-md-7 control-label">Voulez vous réinitialiser le password ?</label>
                      <input
                        class="col-md-1 form-control"
                        type="checkbox"
                        v-model="professeur.create_account"
                      />
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary btn-add" :disabled="valueDisabled">Modifier <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
                    </div> 
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>

import moment from 'moment'

export default {
  data() {
    return {
      title: "Modifier un professeur",
      validated_at: "17/11/1973",
      valueDisabled: false,
      error: null
    };
  },
  created() {
  // recuperation de l'année scolaire
    this.$store.dispatch("getProfesseur", {
      professeurId: this.$route.params.id
    });
  },
  methods:{
    saveProfesseur(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        nom: this.professeur.nom,
        prenom: this.professeur.prenom,
        email: this.professeur.email,
        tel: this.professeur.tel,
        description: this.professeur.description,
        matiere: this.professeur.matiere,
        create_account: this.professeur.create_account,
        school_id: this.$cookies.get('ecoleId')
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "professeurs", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
          this.$router.go(-1)
        })
        .catch(error => {
          this.errored = true;
          this.error = error;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    typesprofesseur(){
      return this.$store.getters.typesprofesseur
    },
    professeur() {
      return this.$store.getters.professeur;
    }
  }
};
</script>
