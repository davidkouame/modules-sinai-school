<template>
  <card class="card" :title="title">
    <div class="row">
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

      <div class="col-md-12">
        <form v-on:submit="saveClasse">
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
                  v-model="classe.libelle"
                  placeholder="Libellé"
                />
                <!---->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Niveaux (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <select v-model="classe.niveau_id" class="form-control">
                  <option value>Sélectionnez un niveau</option>
                  <option :value="niveau.id" v-for="niveau in niveaux">{{ niveau.libelle }}</option>
                </select>
                <!---->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Series (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <select v-model="classe.serie_id" class="form-control">
                  <option value>Sélectionnez une serie</option>
                  <option :value="serie.id" v-for="serie in series">{{ serie.libelle }}</option>
                </select>
                <!---->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Année scolaire (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <select v-model="classe.annee_scolaire_id" class="form-control">
                  <option value>Sélectionnez une année scolaire</option>
                  <option
                    :value="anneescolaire.id"
                    v-for="anneescolaire in anneesscolaires"
                  >{{ anneescolaire.libelle }}</option>
                </select>
                <!---->
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="float-right">
            <div class="row">
              <div class="col-md-12">
                <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a> &nbsp;
                <button type="submit" class="btn btn-primary" :disabled="valueDisabled">
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
      title: "Ajouter une classe",
      classe: {
        libelle: "",
        niveau_id: "",
        serie_id: "",
        annee_scolaire_id: ""
      },
      valueDisabled: false,
      error: null
    };
  },
  created() {
    // recuperation des niveaux
    this.$store.dispatch("getAllNiveaux", { payload: 0 });
    // recuperation des series
    this.$store.dispatch("getAllSeries", { payload: 0 });
    // recuperation de toutes les années scolaires
    this.$store.dispatch("getAllAnneesScolaires", { payload: 0 });
  },
  methods: {
    saveClasse() {
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.classe.libelle,
        niveau_id: this.classe.niveau_id,
        serie_id: this.classe.serie_id,
        annee_scolaire_id: this.classe.annee_scolaire_id,
        school_id: this.$cookies.get("ecoleId"),
        annee_scolaire_id: this.$cookies.get("anneeScolaireId")
      };
      let store = this.$store;
      store
        .dispatch("saveModel", { url: "classes", data: data })
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
    typesclasse() {
      return this.$store.getters.typesclasse;
    },
    niveaux() {
      return this.$store.getters.niveaux;
    },
    series() {
      return this.$store.getters.series;
    },
    anneesscolaires() {
      return this.$store.getters.anneesscolaires;
    }
  }
};
</script>
