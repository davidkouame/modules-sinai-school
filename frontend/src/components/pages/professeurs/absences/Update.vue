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
          <li class="breadcrumb-item active" aria-current="page">Modifier une absence</li>
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
              <h4 class="card-title">Modifier une absence</h4>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Elève (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <select v-model="eleve" class="form-control">
                      <option value="">Sélectionner un élève</option>
                      <option :value="eleve.id" v-for="eleve in eleves">{{ eleve.name+' '+eleve.surname }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Raison d'absence (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
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
                  <label class="col-sm-3 col-form-label">Commentaire (
                  <span class="span-required">*</span>)</label>
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
                <a v-on:click="editAbsenceEleve()" class="btn btn-primary btn-add float-right">Enregistrer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></a>
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
import moment from "moment";

export default {
  name: "EditAbsenceEleve",
  data() {
    return {
      heure_debut_cours: null,
      heure_fin_cours: null,
      commentaire: null,
      raisonabsence: null,
      eleve: null,
      error: null,
      valueDisabled: false
    };
  },
  created() {
    // this.$store.dispatch("elevesProfesseur");
    this.$store.dispatch("elevesProfesseurV2", this.$cookies.get('classeId'));
    this.$store.dispatch("raisonsabsences");
    this.$store.dispatch("absenceeleve", {
      action: "edit",
      absenceEleveId: this.$route.params.id
    });
  },
  methods: {
    editAbsenceEleve() {
      this.error = "";
      this.valueDisabled = true;
      /*const data = new FormData();
      data.append("heure_debut_cours", "2019-09-15");
      data.append("heure_fin_cours", "2019-09-15");
      data.append("raisonabsence_id", 2);
      data.append("eleve_id", 4);
      data.append("commentaire", "dsqhdhqsdqs");*/
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
        section_annee_scolaire_id: this.$cookies.get('sectionAnneeScolaireId'),
        school_id: this.$cookies.get('schoolId'),
        annee_scolaire_id: this.$cookies.get('anneeScolaireId'),
        professeur_id: this.$cookies.get('professeurId')
      };
      // console.log(this.eleve);
      let store = this.$store;
      // console.log(this.$route.params.id);
      // this.$route.params.id;
      store
        .dispatch("absenceselevesP", {
          data: data,
          action: "edit",
          absenceEleveId: this.$route.params.id
        })
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès");
          this.$router.push("/absences");
        })
        .catch(error => {
          console.log(error);
          // alert("echec lors de la mise à jour");
          this.errored = true;
          this.valueDisabled = false;
          this.error = error;
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
    },
    absenceeleve() {
      return this.$store.getters.absenceeleve;
    }
  },
  watch: {
    absenceeleve() {
      this.heure_debut_cours = this.absenceeleve.heure_debut_cours.substring(
        0,
        10
      );
      this.heure_fin_cours = this.absenceeleve.heure_fin_cours.substring(0, 10);
      this.commentaire = this.absenceeleve.commentaire;
      this.eleve = this.absenceeleve.eleve ? this.absenceeleve.eleve.id : null;
      this.raisonabsence = this.absenceeleve.raisonabsence
        ? this.absenceeleve.raisonabsence.id
        : null;
    }
  }
};
</script>