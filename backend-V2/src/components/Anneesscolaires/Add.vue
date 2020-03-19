<template>
  <card class="card" :title="title">
    <div class="row">
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

      <div class="col-md-12">
        <form v-on:submit="saveAnneeScolaire">
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
                  v-model="anneescolaire.libelle"
                  placeholder="Libellé"
                />
                <!---->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Date de début (
                  <span class="span-required">*</span>)
                </label>
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
                <label class="control-label">
                  Date de fin (
                  <span class="span-required">*</span>)
                </label>
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
                <label class="control-label">
                  Type année scolaire (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <select v-model="anneescolaire.type_annee_scolaire_id" class="form-control">
                  <option value>Sélectionnez un type d'année scolaire</option>
                  <option
                    :value="typeanneescolaire.id"
                    v-for="typeanneescolaire in typesanneescolaire"
                  >{{ typeanneescolaire.libelle }}</option>
                </select>
                <!---->
              </div>
            </div>
            <!--<div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de validation</label>
                      <input
                        class="form-control"
                        type="date"
                        v-model="anneescolaire.validated_at"
                        placeholder="Date de validation"
                      />
                    </div>
            </div>-->
          </div>
          <div class="row">
            
          </div>
          <div class="clearfix"></div>
          <div class="float-right">
            <div class="row">
              <div class="col-md-12">
                <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a> &nbsp;
                <button
                  type="submit"
                  class="btn btn-primary"
                  :disabled="valueDisabled"
                >Envoyer</button>
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
      title: "Ajouter unne année scolaire",
      anneescolaire: {
        libelle: "",
        start: "",
        end: "",
        validated_at: "",
        type_annee_scolaire_id: ""
      },
      valueDisabled: false,
      error: null
    };
  },
  created() {
    // recuperation de tous les types d'annnes scolaires
    this.$store.dispatch("getAllTypesAnneeScolaire", { payload: 0 });
  },
  methods: {
    saveAnneeScolaire() {
      this.valueDisabled = true;
      this.error = null;
      // alert("gdgd")
      // console.log("annee scolaire"+JSON.stringify(this.anneescolaire))
      const data = new FormData();
      data.append("libelle", this.anneescolaire.libelle);
      data.append("start", this.anneescolaire.start);
      data.append("end", this.anneescolaire.end);
      data.append("validated_at", this.anneescolaire.validated_at);
      // console.log("l'année scolaire id est "+this.anneescolaire.type_annee_scolaire_id)
      data.append(
        "type_annee_scolaire_id",
        this.anneescolaire.type_annee_scolaire_id
      );
      let store = this.$store;
      store
        .dispatch("saveModel", { url: "anneesscolaires", data: data })
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
    typesanneescolaire() {
      return this.$store.getters.typesanneescolaire;
    }
  }
};
</script>
