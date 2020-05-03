<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

        <div class="col-md-12">
          <form v-on:submit="saveProfesseur">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom (
                  <span class="span-required">*</span>)</label>
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
                      <label class="control-label">Prénom (
                  <span class="span-required">*</span>)</label>
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
                      <label class="control-label">Email (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="email"
                        v-model="professeur.email"
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
                      <label class="control-label">Matière </label>
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
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="professeur.description"></textarea>
                      <!---->
                    </div>
                  </div>
                  <!--<div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Créer un compte user</label>
                      <input
                        class="form-control"
                        type="checkbox"
                        v-model="professeur.create_account"
                      />
                    </div>
                  </div>-->
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
      title: "Ajouter un professeur",
      professeur: {"nom": "", "prenom": "", "email": "", "tel": "", "description": "", "matiere": "", "create_account": ""},
      valueDisabled: false,
      error: null
    };
  },
  methods:{
    saveProfesseur(){
      this.error = null;
      this.valueDisabled = true;
      let data = {
        nom: this.professeur.nom,
        prenom: this.professeur.prenom,
        email: this.professeur.email,
        tel: this.professeur.tel,
        description: this.professeur.description,
        matiere: this.professeur.matiere,
        create_account: this.professeur.create_account,
        school_id: this.$cookies.get('ecoleId')
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "professeurs", "data": data})
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
  }
};
</script>
