<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12">
          <form v-on:submit="saveNiveau">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="niveau.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Ordre</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="niveau.ordre"
                        placeholder="Ordre"
                      />
                      <!---->
                    </div>
                  </div>
                  
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Envoyer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
                    </div>
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Ajouter un niveau",
      niveau: {"libelle": "", "ordre": ""},
      valueDisabled: false,
      error: null
    };
  },
  methods:{
    saveNiveau(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.niveau.libelle,
        ordre: this.niveau.ordre
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "niveaux", "data": data})
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
    typesniveau(){
      return this.$store.getters.typesniveau
    }
  }
};
</script>
