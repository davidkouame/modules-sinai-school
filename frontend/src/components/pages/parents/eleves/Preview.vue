<template>
  <div class="container">
    <div>DetailNote {{ $route.params.id }}</div>
    {{ classesprofesseursmatieres }}
    <form>
      <fieldset v-if="eleve">
        <legend>Information de l'élève</legend>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.name" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Prénoms</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.surname" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Matricule</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.matricule" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Date de naissance</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.datenaissance" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Téléphone</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.tel" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.users.email" disabled />
          </div>
        </div>
      </fieldset>
    </form>
    <a @click="$router.go(-1)" class="btn btn-primary">retour</a>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "DetailEleve",
  data() {
    return {
      searchkeys: null,
      showModal: false,
      eleveId: null,
      noteid: null,
      modelname: null
    };
  },
  created() {
    this.eleveId = this.$route.params.id;
    this.$store.dispatch("eleve", this.eleveId);
    this.fetchAbsence();
    this.fetchNote();
  },
  methods: {
    searchAbsenceEleve() {
      // this.fetch(null, this.searchkeys)
    },
    fetchAbsence(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      if (search) {
        this.$store.dispatch("absenceseleves", {
          payload: pageNum,
          search: [{ key: "libelle", value: search }],
          params: { eleveId: this.eleveId },
          eleveId: this.eleveId
        });
      } else {
        this.$store.dispatch("absenceseleves", {
          payload: pageNum,
          search: null,
          params: { eleveId: this.eleveId },
          eleveId: this.eleveId
        });
      }
    },
    fetchNote(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      if (search) {
        this.$store.dispatch("allnotes", {
          payload: pageNum,
          search: [{ key: "libelle", value: search }]
        });
      } else {
        this.$store.dispatch("allnotes", { payload: pageNum, search: [{key:'professeur_id', value:1}] });
      }
    },
    searchNote() {
      this.fetch(null, this.searchkeys);
    },
    showModalF (noteId = null, modelname = null) {
      this.showModal = true
      this.noteid = noteId
      this.modelname = modelname
    },
    trimSearch(searchs = null){
      let params = [];
      for (var key in searchs) {
        if(searchs[key].value){
          params.push({'key': searchs[key].key, 'value': searchs[key].value});
        }
      }
      return params;
    }
  },
  computed: {
    notes() {
      return this.$store.getters.notes;
    },
    absenceseleves() {
      return this.$store.getters.absenceseleves;
    },
    eleve() {
      return this.$store.getters.eleve;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    pageCountNote() {
      return this.$store.getters.pageCountNote;
    },
    classesprofesseursmatieres(){
      return this.$store.getters.classesprofesseursmatieres
    }
  }
};
</script>
