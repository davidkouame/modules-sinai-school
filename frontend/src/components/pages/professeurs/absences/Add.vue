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
        
        <!-- Show error message -->
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Ajouter une absence</h4>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Elève   (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <select v-model="eleve" class="form-control" >
                      <option value="null">Sélectionner un élève</option>
                      <option :value="eleve.id" v-for="eleve in eleves" v-if="eleves">{{ eleve.name+' '+eleve.surname }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Raison d'absence (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <select v-model="raisonabsence" class="form-control" v-if="raisonsabsences">
                      <option value="null">Sélectionner une raison d'absence</option>
                      <option
                        :value="raisonabsence.id"
                        v-for="raisonabsence in raisonsabsences"
                      >{{ raisonabsence.libelle }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Commentaire</label>
                  <div class="col-sm-9">
                    <textarea v-model="commentaire" class="form-control"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Heure de début de cours (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <datetime
                  v-model="heure_debut_cours"
                  input-class="form-control"
                  type="datetime"
                ></datetime>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Heure de fin de cours (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <datetime
                  v-model="heure_fin_cours"
                  input-class="form-control"
                  type="datetime"
                ></datetime>
                  </div>
                </div>
                <a v-on:click="addAgence()" class="btn btn-primary btn-add float-right">Enregister <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></a>
                <a @click="$router.go(-1)" class="btn btn-danger btn-delete float-right" style="border-right-width: 2px;margin-right: 10px;">Annuler</a>
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
      sectionAnneeScolaireId: this.$cookies.get('sectionAnneeScolaireId'),
      error: null,
      valueDisabled: false
    };
  },
  created() {
    this.$store.dispatch("elevesProfesseurV2", this.$cookies.get('classeId'));
    // console.log("recherche des eleves du professeur");
    this.$store.dispatch("raisonsabsences");
  },
  methods: {
    addAgence() {
      this.error = "";
      this.valueDisabled = true;
      /*let data = {
        heure_debut_cours: "2019-09-15",
        heure_fin_cours: "2019-09-15",
        raisonabsence_id: 1,
        eleve_id: 1,
        commentaire: "dsqhdhqsdqs"
      };*/
      /*const data = new FormData();
      data.append("heure_debut_cours", this.heure_debut_cours);
      data.append("heure_fin_cours", this.heure_fin_cours);
      data.append("raisonabsence_id", this.raisonabsence);
      data.append("eleve_id", this.eleve);
      data.append("commentaire", this.commentaire);
      data.append("section_annee_scolaire_id", this.sectionAnneeScolaireId);*/
      
      let data = {
        heure_debut_cours: this.heure_debut_cours
          .split(".")[0]
          .replace("T", " "),
        heure_fin_cours: this.heure_fin_cours
          .split(".")[0]
          .replace("T", " "),
        raisonabsence_id: this.raisonabsence,
        eleve_id: this.eleve,
        commentaire: this.commentaire,
        section_annee_scolaire_id: this.sectionAnneeScolaireId,
        school_id: this.$cookies.get('schoolId'),
        annee_scolaire_id: this.$cookies.get('anneeScolaireId'),
        professeur_id: this.$cookies.get('professeurId')
      };
      let store = this.$store;
      store
        .dispatch("saveAgence", data)
        .then(response => {
          /*store.dispatch("raisonsabsences", response.data.data);*/
          //this.$router.push("/absences");
          alert("L'enregistrement a été éffectué avec succès");
          this.$router.go(-1);
        })
        .catch(error => {
          console.log(error);
          // alert("echec lors de l'enregistrement");
          this.error = error;
          this.valueDisabled = false;
          //  alert("echec lors de l'enregistrement");
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
      // console.log("liste des raisons d'absences"+this.$store.getters.raisonsabsences)
      return this.$store.getters.raisonsabsences;
    }
  }
};
</script>
