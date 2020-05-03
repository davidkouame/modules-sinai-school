<template>
  <div class="content">
    <div class="container-fluid">
      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#/">Accueil</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#/absences">Absences</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Détailler une note</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Détailler une absence</h4>
            </div>

            <div class="card-body">
              <form v-if="absenceeleve">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Elève</label>
                  <div class="col-sm-10">
                    <input v-bind:value="absenceeleve.eleve.name+' '+absenceeleve.eleve.surname" class="form-control" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Raison d'absence</label>
                  <div class="col-sm-10">
                     <input v-model="absenceeleve.raisonabsence.libelle" class="form-control" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Commentaire</label>
                  <div class="col-sm-10">
                    <textarea v-model="absenceeleve.commentaire" class="form-control" disabled></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Heure de début de cours</label>
                  <div class="col-sm-10">
                    <input v-model="absenceeleve.heure_debut_cours" type="text" class="form-control" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Heure de fin de cours</label>
                  <div class="col-sm-10">
                    <input v-model="absenceeleve.heure_fin_cours" type="text" class="form-control" disabled/>
                  </div>
                </div>
                <a
                  @click="$router.go(-1)"
                  class="btn btn-danger float-right"
                >Annuler</a>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "DetailAbsenceEleve",
  created() {
    this.$store.dispatch("absenceeleve", {
      absenceEleveId: this.$route.params.id
    });
  },
  computed: {
    absenceeleve() {
      return this.$store.getters.absenceeleve;
    }
  },
  watch: {
    absenceeleve(){
      // this.absenceeleve.heure_debut_cours = this.absenceeleve.heure_debut_cours.substring(0, 10);
      // this.absenceeleve.heure_fin_cours = this.absenceeleve.heure_fin_cours.substring(0, 10);
      this.commentaire =this.absenceeleve.commentaire;
      this.eleve = this.absenceeleve.eleve ? this.absenceeleve.eleve.id : null;
      this.raisonabsence = this.absenceeleve.raisonabsence ? this.absenceeleve.raisonabsence.id : null; 
      
    }
  }
};
</script>
