<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

        <div class="col-md-12" v-if="eleve">
          <form v-on:submit="saveEleve">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="eleve.name"
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
                        v-model="eleve.surname"
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
                        v-model="eleve.email"
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
                        v-model="eleve.tel"
                        placeholder="Téléphone"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matricule</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="eleve.matricule"
                        disabled
                      />
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


export default {
  data() {
    return {
      title: "Modifier un élève",
      valueDisabled: false,
      error: null
    };
  },
  created() {
  // recuperation de l'élève
    this.$store.dispatch("getEleve", {
      eleveId: this.$route.params.id
    });
  },
  methods:{
    saveEleve(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        name: this.eleve.name,
        surname: this.eleve.surname,
        email: this.eleve.email,
        tel: this.eleve.tel,
        school_id: this.$cookies.get('ecoleId'),
        annee_scolaire_id: this.$cookies.get('anneeScolaireId')
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "eleves", "data": data, "id": this.$route.params.id})
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
    typeseleve(){
      return this.$store.getters.typeseleve
    },
    eleve() {
      return this.$store.getters.eleve;
    }
  }
};
</script>
