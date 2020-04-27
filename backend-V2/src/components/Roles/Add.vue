<template>
  <card class="card" :title="title">
    <div class="row">
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

      <div class="col-md-12">
        <form v-on:submit="saveRole">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Libellé (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <input
                  class="form-control"
                  type="text"
                  v-model="role.libelle"
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
                <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a> &nbsp;
                <button
                  type="submit"
                  class="btn btn-primary btn-add"
                  :disabled="valueDisabled"
                >
                  Enregistrer
                  <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div>
                </button>
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
      title: "Ajouter un rôle",
      role: {
        libelle: ""
      },
      valueDisabled: false,
      error: null
    };
  },
  created() {
    
  },
  methods: {
    saveRole() {
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.role.libelle,
        school_id: this.$cookies.get("ecoleId"),
        annee_scolaire_id: this.$cookies.get("anneeScolaireId")
      };
      let store = this.$store;
      store
        .dispatch("saveModel", { url: "roles", data: data })
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès");
          this.$router.go(-1);
        })
        .catch(error => {
          this.error = error;
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    
  }
};
</script>
