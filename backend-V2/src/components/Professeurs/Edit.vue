<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="professeur">
          <form v-on:submit="saveProfesseur">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom</label>
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
                      <label class="control-label">Prénom</label>
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
                      <label class="control-label">Email</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.email"
                        placeholder="Email"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Téléphone</label>
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
                      <label class="control-label">Voulez vous réinitialiser le password ?</label>
                      <!---->
                      <input
                        class="form-control"
                        type="checkbox"
                        v-model="professeur.create_account"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="professeur.description"></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Modifier</button>
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
      valueDisabled: false
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
      let data = {
        nom: this.professeur.nom,
        prenom: this.professeur.prenom,
        email: this.professeur.email,
        tel: this.professeur.tel,
        description: this.professeur.description,
        matiere: this.professeur.matiere,
        create_account: this.professeur.create_account,
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "professeurs", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
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
