<template>
  <div id="app" class="container">
    <h1>Editer une absence d'élève</h1>
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
      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
      <a v-on:click="editAbsenceEleve()" class="btn btn-primary">Envoyer</a>
    </form>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  name: "EditAbsenceEleve",
  data(){
    return{
      heure_debut_cours: null,
      heure_fin_cours: null,
      commentaire: null,
      raisonabsence: null,
      eleve: null
    }
  },
  created() {
    this.$store.dispatch("elevesProfesseur");
    this.$store.dispatch("raisonsabsences");
    this.$store.dispatch("absenceeleve", {
      action: "edit",
      absenceEleveId: this.$route.params.id
    });
  },
  methods: {
    editAbsenceEleve() {
      /*const data = new FormData();
      data.append("heure_debut_cours", "2019-09-15");
      data.append("heure_fin_cours", "2019-09-15");
      data.append("raisonabsence_id", 2);
      data.append("eleve_id", 4);
      data.append("commentaire", "dsqhdhqsdqs");*/
      let data = {
        heure_debut_cours: this.heure_debut_cours,
        heure_fin_cours: this.heure_fin_cours,
        raisonabsence_id: this.raisonabsence,
        eleve_id: this.eleve,
        commentaire: this.commentaire
      };
      console.log(this.eleve);
      let store = this.$store;
      store
        .dispatch("absenceselevesP", { data: data, action: "edit", absenceEleveId: this.$route.params.id})
        .then(response => {
          alert("la mise a été éffectué avec succès")
          this.$router.push('/absences')
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de la mise à jour");
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
    },absenceeleve() {
      return this.$store.getters.absenceeleve    
    }
  },
  watch: {
    absenceeleve(){
      this.heure_debut_cours = this.absenceeleve.heure_debut_cours.substring(0, 10);
      this.heure_fin_cours = this.absenceeleve.heure_fin_cours.substring(0, 10);
      this.commentaire =this.absenceeleve.commentaire;
      this.eleve = this.absenceeleve.eleve ? this.absenceeleve.eleve.id : null;
      this.raisonabsence = this.absenceeleve.raisonabsence ? this.absenceeleve.raisonabsence.id : null; 
      
    }
  }
};
</script>