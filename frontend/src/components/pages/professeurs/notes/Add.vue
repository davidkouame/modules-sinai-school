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
            <a href="#/notes">Notes</a>
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
              <h4 class="card-title">Ajouter une note</h4>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Libelle (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" v-model="libelle" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Date de note effectué (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <!--<input type="date" class="form-control" v-model="datenoteeffectue" />-->
                    <datetime
                  v-model="datenoteeffectue"
                  input-class="form-control"
                  type="datetime"
                ></datetime>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Types notes (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <select v-model="typenote" class="form-control">
                      <option value="null">Sélectionner un type de note</option>
                      <option
                        :value="typenote.id"
                        v-for="typenote in typesnotes"
                      >{{ typenote.libelle }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Classes (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <!--<select
                      v-model="classe"
                      class="form-control"
                      multiple="true"
                      v-bind:class="{ 'fix-height': multiple === 'true' }"
                    >
                      <option value>Sélectionner une classe</option>
                      <option
                        :value="classeByProfesseur.classe.id"
                        v-for="classeByProfesseur in classesByProfesseur"
                      >{{ classeByProfesseur.classe.libelle }}</option>
                    </select>-->
                    <select
                      v-model="classe"
                      class="form-control" @change="onChange($event)"                   >
                      <option value="null">Sélectionner une ou plusieurs classes</option>
                      <option
                        :value="classe.classe.id"
                        v-for="classe in classes"
                      >{{ classe.classe.libelle }}</option>
                    </select>
                  </div>
                </div>

                <!-- Matiere -->
                <!--<div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matières</label>
                  <div class="col-sm-10">
                    <select
                      v-model="matiere_id"
                      class="form-control"                    >
                      <option value="null">Sélectionner une matière</option>
                      <option
                        :value="matiere.id"
                        v-for="matiere in matieres"
                      >{{ matiere.libelle }}</option>
                    </select>
                  </div>
                </div>-->
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Matières (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" v-bind:value="matiere ? matiere.libelle : ''" disabled/>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Coefficient (
                  <span class="span-required">*</span>)</label>
                  <div class="col-sm-9">
                    <input v-model="coefficient" type="number" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Description</label>
                  <div class="col-sm-9">
                    <textarea v-model="description" class="form-control"></textarea>
                  </div>
                </div>
                <a v-on:click="createNote()" class="btn btn-primary btn-add float-right">Enregistrer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></a>
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
  name: "AddNote",
  data() {
    return {
      typenote: null,
      description: null,
      libelle: null,
      datenoteeffectue: null,
      // matiere: null,
      classe: null,
      coefficient: null,
      multiple: true,
      matiere_id: null,
      sectionAnneeScolaireId: this.$cookies.get('sectionAnneeScolaireId'),
      error: null,
      valueDisabled: false
    };
  },
  created() {
    this.$store.dispatch("eleves");
    this.$store.dispatch("typesnotes");
    this.$store.dispatch("matieresall");
    this.$store.dispatch('classes', [{'key': 'professeur_id',
    'value': this.$cookies.get('professeurId')}]);
    /*this.$store.dispatch(
      "classesByProfesseur",
      this.$cookies.get("professeurId")
    );*/
  },
  methods: {
    createNote() {
      this.error = "";
      this.valueDisabled = true;
      const data = {};
      data["libelle"] = this.libelle;
      data["datenoteeffectue"] = this.datenoteeffectue
          .split(".")[0]
          .replace("T", " "); // this.datenoteeffectue;
      data["typenote_id"] = this.typenote;
      data["classe_id"] = this.classe;
      data["coefficient"] = this.coefficient;
      data["matiere_id"] = this.matiere ?  this.matiere.id : null;
      data["description"] = this.description;
      data["professeur_id"] = this.$cookies.get("professeurId");
      data["section_annee_scolaire_id"] = this.sectionAnneeScolaireId;
      data["school_id"] = this.$cookies.get('schoolId');
      data["annee_scolaire_id"] = this.$cookies.get('anneeScolaireId');
      // console.log("log data " +);
      /*data.append('datenoteeffectue', this.datenoteeffectue);
      data.append('description', this.description);
      data.append('typenote_id', this.typenote);
      data.append('matiere_id', this.matiere);
      data.append('coefficient', this.coefficient);*/

      let store = this.$store;
      store
        .dispatch("saveNoteP", data)
        .then(response => {
          store.dispatch("raisonsabsences", response.data.data);
          alert("L'enregistrement a été éffectué avec succès");
          // this.$router.push('/notes')
          this.$router.go(-1);
        })
        .catch(error => {
          console.log(error);
          this.error = error;
          this.valueDisabled = false;
          // alert("echec lors de l'enregistrement");
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    onChange(event) {
      if(event.target.value){
        let params = [
          { key: "classe_id", value: event.target.value },
          { key: "professeur_id", value: this.$cookies.get('professeurId') }
        ];
        this.$store.dispatch("searchMatiereByClasseAndProfesseur", {
          search: this.trimSearch(params)
        });
      }else{
        // todo when classe is null
      }
      // console.log("classe_id "+event.target.value+", professeur_id "+this.$cookies.get("professeurId"))

    },
    trimSearch(searchs = null) {
      let params = [];
      for (var key in searchs) {
        if (searchs[key].value) {
          params.push({ key: searchs[key].key, value: searchs[key].value });
        }
      }
      return params;
    },
  },
  computed: {
    eleves() {
      return this.$store.getters.eleves;
    },
    typesnotes() {
      return this.$store.getters.typesnotes;
    },
    matieres() {
      // let matieres = this.$store.getters.matieres;
      // console.log("liste des matieres "+JSON.stringify(matieres));
      // return matieres;
      return this.$store.getters.matieres;
    },
    classesByProfesseur() {
      return this.$store.getters.classesByProfesseur;
    },
    classes () {
      return this.$store.getters.classes
    },
    matiere(){
      return this.$store.getters.matiere;
    }
  },
  watch:{
    matiere(){
      console.log("matiere ")
    }
  }
};
</script>