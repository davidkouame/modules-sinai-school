<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

        <div class="col-md-12">
          <form v-on:submit="saveMatiere">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="note.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de création (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <datetime v-model="note.datenoteeffectue" input-class="form-control" type="datetime"></datetime>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                      <label class="control-label">Type de note (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="note.typenote_id" class="form-control" >
                      <option value="">Sélectionnez un type de note</option>
                      <option :value="typenote.id" v-for="typenote in typesnote">{{ typenote.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                      <label class="control-label">Matière (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="note.matiere_id" class="form-control" >
                      <option value="">Sélectionnez une matière</option>
                      <option :value="matiere.id" v-for="matiere in matieres">{{ matiere.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coefficient (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="note.coefficient"
                        placeholder="Coéfficient"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Classe (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="note.classe_id" class="form-control" >
                      <option value="">Sélectionnez une classe</option>
                      <option :value="classe.id" v-for="classe in classes">{{ classe.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                </div>
                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Section année scolaire (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="note.section_annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une section</option>
                      <option :value="sectionanneescolaire.id" v-for="sectionanneescolaire in sectionsanneescolaire">{{ sectionanneescolaire.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="note.description"></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary btn-add" :disabled="valueDisabled">Enregistrer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
                    </div>
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Ajouter une note",
      note: {"libelle": "", "datenoteeffectue": "", "description": "", "typenote_id": "",
      "matiere_id": "", "coefficient": "", "classe_id": "", "section_annee_scolaire_id": ""},
      valueDisabled: false,
      error: null
    };
  },
  created() {
    // recuperation de tous les types de notes
    this.$store.dispatch('getAllTypesNote', {payload: 0 , search: [
        {key: 'school_id', value: this.$cookies.get('ecoleId')},
        {key: 'annee_scolaire_id', value: this.$cookies.get('anneeScolaireId')}
        ] });
    // recuperation de toutes les matieres
    this.$store.dispatch('getAllMatieres', {payload: 0});
    // recuperation de toutes les classes
    this.$store.dispatch('getAllClasses', {payload: 0, search: [
        {key: 'school_id', value: this.$cookies.get('ecoleId')},
        {key: 'annee_scolaire_id', value: this.$cookies.get('anneeScolaireId')}
        ] });
    // recuperation de toutes les sections annee scolaire
    this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0, search: [
        {key: 'school_id', value: this.$cookies.get('ecoleId')},
        {key: 'annee_scolaire_id', value: this.$cookies.get('anneeScolaireId')}
        ] })
    // console.log("liste des refs "+JSON.stringify(this))
  },
  methods:{
    saveMatiere(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.note.libelle,
        datenoteeffectue: this.note.datenoteeffectue.split(".")[0].replace('T', ' '),
        description: this.note.description,
        typenote_id: this.note.typenote_id,
        matiere_id: this.note.matiere_id,
        coefficient: this.note.coefficient,
        classe_id: this.note.classe_id,
        section_annee_scolaire_id: this.note.section_annee_scolaire_id,
        school_id: this.$cookies.get('ecoleId'),
        annee_scolaire_id: this.$cookies.get('anneeScolaireId')
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "notemodel", "data": data})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
          this.$router.go(-1)
        })
        .catch(error => {
          this.error = error;
          this.valueDisabled = false;
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    typesnote(){
      return this.$store.getters.typesnote
    },
    matieres(){
      return this.$store.getters.matieres
    },
    classes(){
      return this.$store.getters.classes
    },
    sectionsanneescolaire(){
      return this.$store.getters.sectionsanneescolaire
    }
  }
};
</script>
<style>
  .spinner-border-customize {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.25em solid currentColor;
        border-right-color: currentcolor;
    border-right-color: 
    transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .75s linear infinite;
    animation: spinner-border .75s linear infinite;
}
</style>
