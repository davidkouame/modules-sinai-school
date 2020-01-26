<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12" v-if="typemoyenne">
          <form v-on:submit="saveRaisonAbsence">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="typemoyenne.libelle"
                        placeholder="Libellé"
                      />
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
      title: "Modifier un type de moyenne",
      validated_at: "17/11/1973",
      valueDisabled: false,
      error: null
    };
  },
  created() {
    this.$store.dispatch("getTypeMoyenne", {
      id: this.$route.params.id
    });
  },
  methods:{
    saveRaisonAbsence(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.typemoyenne.libelle
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "typesmoyenne", "data": data, "id": this.$route.params.id})
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
    typemoyenne(){
      return this.$store.getters.typemoyenne
    }
  }
};
</script>
