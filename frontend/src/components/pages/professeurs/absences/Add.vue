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
          <li class="breadcrumb-item active" aria-current="page">Ajouter une note</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Ajouter une absence</h4>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row" v-if="eleves">
                  <label class="col-sm-2 col-form-label">Elève</label>
                  <div class="col-sm-10">
                    <select v-model="eleve" class="form-control" >
                      <option value="null">Sélectionner un élève</option>
                      <option :value="eleve.id" v-for="eleve in eleves">{{ eleve.name+' '+eleve.surname }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Raison d'absence</label>
                  <div class="col-sm-10">
                    <select v-model="raisonabsence" id class="form-control">
                      <option value="null">Sélectionner une raison d'absence</option>
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
                <a v-on:click="addAgence()" class="btn btn-primary float-right">Envoyer</a>
                <a @click="$router.go(-1)" class="btn btn-danger float-right" style="border-right-width: 2px;margin-right: 10px;">Annuler</a>
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
  name: "AddAbsenceEleve",
  data() {
    return {
      eleve: null,
      raisonabsence: null,
      commentaire: null,
      heure_debut_cours: null,
      heure_fin_cours: null,
      sectionAnneeScolaireId: this.$cookies.get('sectionAnneeScolaireId')
    };
  },
  created() {
    this.$store.dispatch("elevesProfesseurV2");
    console.log("recherche des eleves du professeur");
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
      data.append("heure_debut_cours", this.heure_debut_cours);
      data.append("heure_fin_cours", this.heure_fin_cours);
      data.append("raisonabsence_id", this.raisonabsence);
      data.append("eleve_id", this.eleve);
      data.append("commentaire", this.commentaire);
      data.append("section_annee_scolaire_id", this.sectionAnneeScolaireId);
      let store = this.$store;
      store
        .dispatch("saveAgence", data)
        .then(response => {
          /*store.dispatch("raisonsabsences", response.data.data);*/
          alert("L'enregistrement a été succès");
          this.$router.push("/absences");
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement");
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    eleves() {
      let eleves = this.$store.getters.eleves;
      console.log("liste des eleves ");
      return eleves;
    },
    raisonsabsences() {
      return this.$store.getters.raisonsabsences;
    }
  }
};
</script>
