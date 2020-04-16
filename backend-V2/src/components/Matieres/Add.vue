<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12">
          <form v-on:submit="saveMatiere">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="matiere.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Type de matière (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="matiere.typematiere_id" class="form-control" >
                      <option value="">Sélectionnez un type de matiere</option>
                      <option :value="typematiere.id" v-for="typematiere in typesmatiere">{{ typematiere.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="matiere.description"></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary btn-add" :disabled="valueDisabled">Enregistrer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
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
      title: "Ajouter une matière",
      matiere: {"libelle": "", "typematiere_id": "", "description": ""},
      valueDisabled: false,
      error: null
    };
  },
  created() {
    // recuperation de tous les types de matieres
    this.$store.dispatch('getAllTypesMatiere', {payload: 0})
  },
  methods:{
    saveMatiere(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.matiere.libelle,
        typematiere_id: this.matiere.typematiere_id,
        description: this.matiere.description
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "matieres", "data": data})
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
    typesmatiere(){
      return this.$store.getters.typesmatiere
    }
  }
};
</script>
