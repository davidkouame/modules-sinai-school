<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="absence">
          <form v-on:submit="saveAbsence">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Elève</label>
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
                      <label class="control-label">Raison d'absence</label>
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
                      <label class="control-label">Heure de début</label>
                      <!---->
                      <datetime v-model="heure_debut" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de fin</label>
                      <!---->
                      <datetime v-model="heure_fin" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="absence.commentaire"></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
      <button type="submit" class="btn btn-primary">Modifier</button>
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
      title: "Année scolaire",
      heure_debut: null, // "2018-05-12T17:19:06.00000"
      heure_fin: null
    };
  },
  created() {
  // recuperation de l'absence
    this.$store.dispatch("getAbsence", {
      absenceId: this.$route.params.id
    });
    // recuperation des eleves
    this.$store.dispatch('getAllEleves', {payload: 0})
    // recuperation des raisons d'absences
    this.$store.dispatch('getAllRaisonsAbsences', {payload: 0})
  },
  methods:{
    saveAbsence(){
      let data = {
        eleve_id: this.absence.eleve_id,
        raisonabsence_id: this.absence.raisonabsence_id,
        commentaire: this.absence.description,
        heure_debut_cours: this.heure_debut.split(".")[0].replace('T', ' '),
        heure_fin_cours: this.heure_fin.split(".")[0].replace('T', ' '),
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "absenceseleves", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
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
