<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>

        <div class="col-md-12" v-if="absence">
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
                      <datetime v-model="heure_debut" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de fin (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <datetime v-model="heure_fin" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Sections année scolaire (
                  <span class="span-required">*</span>)</label>
                      <select v-model="absence.section_annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une section année scolaire</option>
                      <option :value="sectionanneescolaire.id" v-for="sectionanneescolaire in sectionsanneescolaire">{{ sectionanneescolaire.libelle }} </option>
                      </select>
                    </div>
            </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="absence.commentaire"></textarea>
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

import moment from 'moment'

export default {
  data() {
    return {
      title: "Modifier une absence",
      heure_debut: null, // "2018-05-12T17:19:06.00000"
      heure_fin: null,
      valueDisabled: false,
      error: null
    };
  },
  created() {
  // recuperation de l'absence
    this.$store.dispatch("getAbsence", {
      absenceId: this.$route.params.id
    });
    // recuperation des eleves
    this.$store.dispatch('getAllEleves', {payload: 0, search : [
      {key: "school_id", value: this.$cookies.get('ecoleId')},
      {key: "annee_scolaire_id", value: this.$cookies.get('anneeScolaireId')}]})
    // recuperation des raisons d'absences
    this.$store.dispatch('getAllRaisonsAbsences', {payload: 0})
    // recuperation de toutes les sections annee scolaire
    this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0, search: [
        {key: 'school_id', value: this.$cookies.get('ecoleId')},
        {key: 'annee_scolaire_id', value: this.$cookies.get('anneeScolaireId')}
        ] })
  },
  methods:{
    saveAbsence(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        eleve_id: this.absence.eleve_id,
        raisonabsence_id: this.absence.raisonabsence_id,
        commentaire: this.absence.description,
        heure_debut_cours: this.heure_debut.split(".")[0].replace('T', ' '),
        heure_fin_cours: this.heure_fin.split(".")[0].replace('T', ' '),
        school_id: this.$cookies.get('ecoleId'),
        annee_scolaire_id: this.$cookies.get('anneeScolaireId'),
        section_annee_scolaire_id: this.absence.section_annee_scolaire_id
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "absenceseleves", "data": data, "id": this.$route.params.id})
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
    absence() {
      return this.$store.getters.absence;
    },
    eleves(){
      return this.$store.getters.eleves
    },
    raisonsabsences(){
      return this.$store.getters.raisonsabsences
    },
    sectionsanneescolaire(){
      return this.$store.getters.sectionsanneescolaire
    }
  },
  watch:{
    absence(){
      this.heure_debut = this.absence.heure_debut_cours.replace(' ', 'T')+'.00000'
      this.heure_fin = this.absence.heure_fin_cours.replace(' ', 'T')+'.00000'
    }
  }
};
</script>
