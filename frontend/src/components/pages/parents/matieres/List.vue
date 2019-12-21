<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <card class="strpied-tabled-with-hover" body-classes="table-full-width table-responsive">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des matières</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <!-- Zone de recherche -->
                <!--<div class="float-right col-4" style="padding-right: 0px;">
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      v-model="searchkeys"
                      placeholder="Rechercher une matière"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                    />
                    <div class="input-group-append search-parent">
                      <button
                        class="btn btn-outline-secondary"
                        id="button-addon2"
                        v-on:click="searchmatiere"
                      >rechercher</button>
                    </div>
                  </div>
                </div>-->

                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Libellé</th>
                      <th scope="col">Coefficient</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countMatieres" v-for="(matiere, index) in matieres">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ matiere.libelle }}</td>
                      <td>{{ matiere.coefficient }}</td>
                      <td class="actions">
                        <a :href="'/#/matieres/preview/'+matiere.id">
                          <i class="fa fa-eye fa-lg"></i>
                        </a>
                      </td>
                    </tr>

                    <tr v-if="!countMatieres">
                      <td colspan="2" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "Listmatiere",
  data() {
    return {
      msg: "Liste des matieres",
      searchkeys: null,
      showModal: false,
      matiereid: null,
      countMatieres: false
    };
  },
  created() {
    this.refreshList();
    // this.classeId = this.$store.getters.classeId;
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        { key: "eleve_id", value: this.eleveListId },
        { key: "parent_id", value: localStorage.getItem("parentId") },
        { key: "classe_id", value: this.classeListId },
        { key: "annee_scolaire_id", value: this.anneeScolaireId }
      ];
      this.$store.dispatch("matieresV2", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchmatiere() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(matiereId = null) {
      this.showModal = true;
      this.matiereid = matiereId;
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
    refreshList(){
        if(this.eleveListId && this.anneeScolaireId){
            this.fetch();
        }
    },
    getCoefficientMatiere(id){
        let classeId = this.classeListId;
        let coefficient = null;
        let e = this.matieres.find(function(element){
            let response = null;
            if(element.id == id){
                response = element.classematiere.find(function(keyment){
                    // console.log(">>>>>>>> keyment "+JSON.stringify(keyment)+" >>>>> id"+ id);
                    if(keyment.matiere_id == id ){

                            // console.log(">>>>>>>> keyment "+JSON.stringify(keyment.coefficient));
                        coefficient = keyment.coefficient;
                    }
                })
                // coefficient = response.coefficient;
            }
            // console.log(">>>>>>>> id "+JSON.stringify(response));
        })
         // console.log(">>>>>>>> e "+JSON.stringify(e));
         return coefficient;
    }
  },
  computed: {
    matieres() {
      this.countMatieres = this.$store.getters.matieres.length > 0;
      // console.log("liste des matieres "+JSON.stringify(this.$store.getters.matieres));
      return this.$store.getters.matieres;
    },
    classeListId() {
      return this.$store.getters.classeId;
    },
    eleveListId() {
      let eleveId = this.$store.getters.eleveId;
      localStorage.setItem("eleveId", eleveId);
      return eleveId;
    },
    anneeScolaireId(){
        return this.$store.getters.anneeScolaireId ;
    }
  },
  watch: {
    eleveListId() {
      localStorage.setItem("eleveId", this.eleveListId);
      this.refreshList();
    },
    anneeScolaireId(){
        // console.log(this.sectionAnneeScolaireId);
        // this.fetch();
        this.refreshList();
    }
  }
};
</script>
