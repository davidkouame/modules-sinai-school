<template>
  <div id="app" class="container">
    <h1>Ajouter une absence d'élève</h1>
    <form>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Elève</label>
        <div class="col-sm-10">
          <select v-model="eleve" class="form-control">
            <option :value="eleve.id" v-for="eleve in eleves">{{ eleve.matricule }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Raison d'absence</label>
        <div class="col-sm-10">
          <select v-model="raisonabsence" id class="form-control">
            <option value>Sélectionner une raison d'absence</option>
            <option
              :value="raisonabsence.id"
              v-for="raisonabsence in raisonsabsences"
            >{{ raisonabsence.libelle }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Commentaire</label>
        <div class="col-sm-10">
          <textarea v-model="commentaire" class="form-control"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Heure de début de cours</label>
        <div class="col-sm-10">
          <input v-model="heure_debut_cours" type="date" class="form-control" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Heure de fin de cours</label>
        <div class="col-sm-10">
          <input v-model="heure_fin_cours" type="date" class="form-control" />
        </div>
      </div>
      <a :href="'/#/absences-eleves'" class="btn btn-danger">Annuler</a>
      <a v-on:click="addAgence()" class="btn btn-primary">Envoyer</a>
    </form>
  </div>
</template>

<script>
export default {
  name: "AddAbsenceEleve",
  data() {
    return {
      eleve: null,
      raisonabsence: null,
      commentaire: null,
      heure_debut_cours: null,
      heure_fin_cours: null
    };
  },
  created() {
    this.$store.dispatch("eleves");
    this.$store.dispatch("raisonsabsences");
  },
  methods: {
    addAgence() {
      
      /*let data = {
        heure_debut_cours: "2019-09-15",
        heure_fin_cours: "2019-09-15",
        raisonabsence_id: 1,
        eleve_id: 1,
        commentaire: "dsqhdhqsdqs"
      };*/
      const data = new FormData();
      data.append('heure_debut_cours', this.heure_debut_cours);
      data.append('heure_fin_cours', this.heure_fin_cours);
      data.append('raisonabsence_id', this.raisonabsence);
      data.append('eleve_id', this.eleve);
      data.append('commentaire', this.commentaire);
      let store = this.$store;
      store
        .dispatch("saveAgence", data)
        .then(response => {
          store.dispatch("raisonsabsences", response.data.data);
          alert("L'enregistrement a été succès")
          this.$router.push('/absences-eleves')
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    eleves() {
      return this.$store.getters.eleves;
    },
    raisonsabsences() {
      return this.$store.getters.raisonsabsences;
    }
  }
};
</script>