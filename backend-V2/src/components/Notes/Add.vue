<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-on:submit="saveMatiere">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
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
                      <label class="control-label">Date de création</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="note.datenoteeffectue"
                        placeholder="Date de création"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                      <label class="control-label">Type de note</label>
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
                      <label class="control-label">Matière</label>
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
                      <label class="control-label">Coefficient</label>
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
                      <label class="control-label">Classe</label>
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
                      <label class="control-label">Section année scolaire</label>
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
                <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
      <button type="submit" class="btn btn-primary">Envoyer</button>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Notes",
      note: {"libelle": "", "datenoteeffectue": "", "description": "", "typenote_id": "",
      "matiere_id": "", "coefficient": "", "classe_id": "", "section_annee_scolaire_id": ""}
    };
  },
  created() {
    // recuperation de tous les types de notes
    this.$store.dispatch('getAllTypesNote', {payload: 0})
    // recuperation de toutes les matieres
    this.$store.dispatch('getAllMatieres', {payload: 0})
    // recuperation de toutes les classes
    this.$store.dispatch('getAllClasses', {payload: 0})
    // recuperation de toutes les sections annee scolaire
    this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0})
  },
  methods:{
    saveMatiere(){
      let data = {
        libelle: this.note.libelle,
        datenoteeffectue: this.note.datenoteeffectue,
        description: this.note.description,
        typenote_id: this.note.typenote_id,
        matiere_id: this.note.matiere_id,
        coefficient: this.note.coefficient,
        classe_id: this.note.classe_id,
        section_annee_scolaire_id: this.note.section_annee_scolaire_id,
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "notemodel", "data": data})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
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
      return this.$store.getters.classes
    }
  }
};
</script>
