<template>
  <div class="container">
    <div>Détail absence note {{ $route.params.id }}</div>
    <ul>
      <li>Id : {{ absenceeleve.id }}</li>
      <li>Heure de début : {{ absenceeleve.heure_debut_cours }}</li>
      <li>Heure de fin : {{ absenceeleve.heure_fin_cours }}</li>
      <li>Raison absence  : {{ absenceeleve.raisonabsence.libelle }}</li>
      <li>Commentaire  : {{ absenceeleve.commentaire }}</li>
    </ul>
  <a :href="'/#/absence-eleve'" class="btn btn-primary">retour</a>
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
          console.log("log absence eleve"+this.$store.getters.absenceeleve);
          return this.$store.getters.absenceeleve
      }
  }
};
</script>
