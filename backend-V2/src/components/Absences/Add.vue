<template>
  <card class="card" :title="title">
      <div class="row">

        <!-- Show error message -->
        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12">
          <form v-on:submit="saveAbsence">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Elève (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="absence.eleve_id" class="form-control" >
                      <option value="">Sélectionnez un élève</option>
                      <option :value="eleve.id" v-for="eleve in eleves">{{ eleve.name }} {{ eleve.surname }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">Raison d'absence (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="absence.raisonabsence_id" class="form-control" >
                      <option value="">Sélectionnez une raison</option>
                      <option :value="raisonabsence.id" v-for="raisonabsence in raisonsabsences">{{ raisonabsence.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de début (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <datetime v-model="absence.heure_debut_cours" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de fin (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <datetime v-model="absence.heure_fin_cours" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Sections année scolaire</label>
                      <!---->
                      <select v-model="absence.section_annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une section année scolaire</option>
                      <option :value="sectionanneescolaire.id" v-for="sectionanneescolaire in sectionsanneescolaire">{{ sectionanneescolaire.libelle }} </option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="absence.description"></textarea>
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
      title: "Ajouter une absence",
      absence: {"eleve_id": "", "raisonabsence_id": "", "description": "", "heure_debut_cours": "", "heure_fin_cours": "", "section_annee_scolaire_id": ""},
      date: null,
      valueDisabled: false,
      error: null
    };
  },
  created() {
    // recuperation des eleves
    this.$store.dispatch('getAllEleves', {payload: 0})
    // recuperation des raisons d'absences
    this.$store.dispatch('getAllRaisonsAbsences', {payload: 0})
    // recuperation des sections de classes
    this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0})
  },
  methods:{
    saveAbsence(){
      this.valueDisabled = true
      let data = {
        eleve_id: this.absence.eleve_id,
        raisonabsence_id: this.absence.raisonabsence_id,
        commentaire: this.absence.description,
        heure_debut_cours: this.absence.heure_debut_cours.split(".")[0].replace('T', ' '),
        heure_fin_cours: this.absence.heure_fin_cours.split(".")[0].replace('T', ' '),
        section_annee_scolaire_id: this.absence.section_annee_scolaire_id
      };
      let store = this.$store;
      // console.log("data "+JSON.stringify(data))
      // return 0;
      store
        .dispatch("saveModel", {"url": "absenceseleves", "data": data})
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
    eleves(){
      return this.$store.getters.eleves
    },
    raisonsabsences(){
      return this.$store.getters.raisonsabsences
    },
    sectionsanneescolaire(){
      return this.$store.getters.sectionsanneescolaire
    }
  }
};
</script>
