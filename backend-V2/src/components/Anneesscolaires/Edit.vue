<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="anneescolaire">
          <form v-on:submit="saveAnneeScolaire">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="anneescolaire.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de début</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="anneescolaire.start"
                        placeholder="Date de début"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de fin</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="anneescolaire.end"
                        placeholder="Date de fin"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de validation</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="validated_at"
                        placeholder="Date de validation"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Type année scolaire</label>
                      <!---->
                      <select v-model="anneescolaire.type_annee_scolaire_id" class="form-control" >
                      <option value="null">Sélectionnez un type d'année scolaire</option>
                      <option :value="typeanneescolaire.id" v-for="typeanneescolaire in typesanneescolaire">{{ typeanneescolaire.libelle }}</option>
                      </select>
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
      title: "Modifier une année scolaire",
      validated_at: "17/11/1973",
      valueDisabled: false
    };
  },
  created() {
  // recuperation de l'année scolaire
    this.$store.dispatch("getAnneeScolaire", {
      anneeScolaireId: this.$route.params.id
    });
    // recuperation de tous les types d'annnes scolaires
    this.$store.dispatch('getAllTypesAnneeScolaire', {payload: 0})
  },
  methods:{
    saveAnneeScolaire(){
      // console.log("annee scolaire"+JSON.stringify(this.anneescolaire))
      this.valueDisabled = true;
      let data = {
        libelle: this.anneescolaire.libelle,
        start: this.anneescolaire.start,
        end: this.anneescolaire.end,
        validated_at: this.anneescolaire.validated_at,
        type_annee_scolaire_id: this.anneescolaire.type_annee_scolaire_id,
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "anneesscolaires", "data": data, "id": this.$route.params.id})
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
    typesanneescolaire(){
      return this.$store.getters.typesanneescolaire
    },
    anneescolaire() {
      return this.$store.getters.anneescolaire;
    }
  }
};
</script>
