<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-on:submit="saveEleve">
                <div class="row">
                  <div class="col-md-6">
                    <label class="control-label">Elève</label>
                    <div class="form-group" v-if="eleves">
                      <v-select :options="eleves"  multiple  v-model="elevesclasse" label="matricule">
                        <template slot="option" slot-scope="option">
                            {{ option.matricule }} : {{ option.name+' '+option.surname }}
                          </template>
                      </v-select>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Enregistrer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
                    </div>
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>

import 'vue-select/dist/vue-select.css';


export default {
  data() {
    return {
      title: "Ajouter un élève classe",
      elevesclasse: null,
      valueDisabled: false
    };
  },
  created() {
    // recuperation de tous les élèves
    this.$store.dispatch('getAllEleves', {payload: 0})
    // recuperation de la classe
    this.$store.dispatch('getClasse', {classeId: this.$route.params.id})
  },
  methods:{
    saveEleve(){
      this.valueDisabled = true;
      let data = {
        eleves: this.elevesclasse,
        classe_id: this.$route.params.id,
        annee_scolaire_id: this.classe.annee_scolaire_id
      };
      let store = this.$store;
      store
        .dispatch("saveElevesClasse", {"data": data})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
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
    eleves(){
      return this.$store.getters.eleves
    },
    classe(){
      return this.$store.getters.classe
    }
  }
};
</script>
