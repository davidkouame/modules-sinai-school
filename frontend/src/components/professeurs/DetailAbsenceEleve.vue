<template>
  <div class="container">
    <div>Détail absence note {{ $route.params.id }}</div>
    <ul v-if="absenceeleve">
      <li>Id : {{ absenceeleve.id }}</li>
      <li>Heure de début : {{ absenceeleve.heure_debut_cours }}</li>
      <li>Heure de fin : {{ absenceeleve.heure_fin_cours }}</li>
      <li>Raison absence  : <span v-if="absenceeleve.raisonabsence">{{ absenceeleve.raisonabsence.libelle }}</span></li>
      <li>Commentaire  : {{ absenceeleve.commentaire }}</li>
      <li>Elève  : <span v-if="absenceeleve.eleve">{{ absenceeleve.eleve.matricule }}</span></li>
    </ul>
  <a :href="'#/professeur/absences-eleves'" class="btn btn-primary">retour</a>
  </div>
</template>

<script>
export default {
  name: "DetailAbsenceEleve",
  created(){
      this.$store.dispatch('absenceeleve', {absenceEleveId: this.$route.params.id})
  },
  computed:{
      absenceeleve(){
          return this.$store.getters.absenceeleve
      }
  }
};
</script>
