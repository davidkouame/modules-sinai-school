<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12" v-if="serie">
          <form v-on:submit="saveserie">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="serie.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <!--<div class="form-group">
                      <label class="control-label">Type de matière</label>
                      <select v-model="serie.typeserie_id" class="form-control" >
                      <option value="">Sélectionnez un type de serie</option>
                      <option :value="typeserie.id" v-for="typeserie in typesserie">{{ typeserie.libelle }}</option>
                      </select>
                    </div>-->
                </div>
                <!--<div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <textarea class="form-control" v-model="serie.description"></textarea>
                    </div>
                  </div>
                </div>-->
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Modifier <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
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
      title: "Modifier une serie",
      validated_at: "17/11/1973",
      valueDisabled: false,
      error: null
    };
  },
  created() {
    // recuperation de la serie
    this.$store.dispatch("getSerie", {
      serieId: this.$route.params.id
    });
  },
  methods:{
    saveserie(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.serie.libelle
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "series", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
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
    serie() {
      return this.$store.getters.serie;
    }
  }
};
</script>
