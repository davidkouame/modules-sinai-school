<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12" v-if="anneescolaire">
          <form v-on:submit="saveAnneeScolaire">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé (
                  <span class="span-required">*</span>)</label>
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
                      <label class="control-label">Date de début (
                  <span class="span-required">*</span>)</label>
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
                      <label class="control-label">Date de fin (
                  <span class="span-required">*</span>)</label>
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
                      <input
                        class="form-control"
                        type="date"
                        v-model="validated_at"
                        placeholder="Date de validation"
                        disabled
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Type année scolaire (
                  <span class="span-required">*</span>)</label>
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
                      <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary btn-add" :disabled="valueDisabled">Modifier</button>
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
      validated_at: "",
      valueDisabled: false,
      error: null
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
      this.error = null;
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
          alert("L'enregistrement a été éffectué avec succès")
          this.$router.go(-1)
        })
        .catch(error => {
          this.error = error;
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
  },
  watch:{
    anneescolaire() {
      let validated_at = this.anneescolaire.validated_at.split(" ")[0];
      // console.log("&&&&&&& "+validated_at);
      this.validated_at = validated_at;
      // validated_at = validated_at.split("/");
      // this.validated_at = validated_at[2]+"-"+validated_at[1]+"-"+validated_at[0];
      // this.validated_at = "2020-02-02";
    }
  }
};
</script>
