<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="note">
          <form v-on:submit="saveNote">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="note.reference"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
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
      <button type="submit" class="btn btn-primary">Modifier</button>
              </form>
        </div>
      </div>
  </card>
</template>

<script>

import moment from 'moment'

export default {
  data() {
    return {
      title: "Année scolaire",
      validated_at: "17/11/1973"
    };
  },
  created() {
    this.$store.dispatch("getNote", {
      noteId: this.$route.params.id
    });
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
    saveNote(){
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
        .dispatch("updateModel", {"url": "notemodel", "data": data, "id": this.$route.params.id})
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
    note(){
      return this.$store.getters.note
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
