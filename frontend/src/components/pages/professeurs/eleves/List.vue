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
            <a href="#/eleves">Elèves</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Liste des élèves</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des élèves </h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <!-- Zone de recherche -->
                <div class="row">
                    <div class="float-left col-2">
                        <base-dropdown v-bind:title="titleDropdownClasse">
                            <a v-for="classe in classes" class="dropdown-item"
                                href="javascript:void(0)" @click="changeClasse(classe)">
                              {{ classe.classe.libelle }}
                              <i class="fa fa-check"  :class="{check:classe.classe.id == classeId}" ></i>
                            </a>
                        </base-dropdown>
                    </div>
                    <div class="float-right offset-md-4 col-6">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="input-group mb-3">
                                    <input
                                      type="text"
                                      class="form-control"
                                      v-model="searchkeys"
                                      placeholder="Rechercher un élève"
                                      aria-label="Recipient's username"
                                      aria-describedby="button-addon2"
                                    />
                                    <div class="input-group-append search-parent">
                                      <button
                                        class="btn btn-outline-secondary"
                                        id="button-addon2"
                                        v-on:click="searchEleve"
                                      >rechercher</button>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-md-1">
                                <div class="col-1 add-form">
                                    <a :href="'#/notes/add'">
                                      <i class="fa fa-plus-circle fa-lg font-size-28"></i>
                                    </a>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>

                <table class="table table-d">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Prénoms</th>
                      <th scope="col">Matricule</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countEleves" v-for="(eleve, index) in eleves">
                      <td scope="row">{{ index + 1}}</td>
                      <td>{{ eleve.eleve.name }}</td>
                      <td>{{ eleve.eleve.matricule }}</td>
                      <td>
                        <!--<a :href="'#/absence-eleve/'+absenceeleve.id" class="btn btn-primary">detail</a>-->

                        <a :href="'#/eleves/preview/'+eleve.eleve.id" class="btn-icon btn-info btn-sm">
                          <i class="fa fa-eye"></i>
                        </a>
                        <!--<a :href="'#/absences-eleves/update/'+absenceeleve.id" class="btn btn-primary">Modifier</a>-->
                        <!--<button id="show-modal" @click="showModalF(absenceeleve.id)" class="btn btn-danger">Supprimer</button>-->
                      </td>
                    </tr>
                    <tr v-if="!countEleves">
                      <td colspan="3" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <!-- Pagination -->
                <div class="row" v-if="pageCount > 1">
                  <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                    Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                  </div>
                  <div class="col-md-8">
                    <div class="float-right pagi">
                      <paginate
                        :page-count="pageCount"
                        :click-handler="fetch"
                        :prev-text="'&laquo;'"
                        :next-text="'&raquo;'"
                        :container-class="'pagination'"
                        :page-class="'page-item'"
                      ></paginate>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "ListEleve",
  data() {
    return {
      msg: "Liste des élèves",
      searchkeys: null,
      showModal: false,
      absenceid: null,
      countEleves: null,
      titleDropdownClasse: null,
      countAbsences: null,
      classeId: null
      // sectionAnneeScolaireId: this.$cookies.get('sectionAnneeScolaireId'),
      // anneeScolaireId: this.$cookies.get('anneeScolaireId')
    };
  },
  created() {
    this.fetch();
    this.$store.dispatch('classes', [{'key': 'professeur_id',
      'value': this.$cookies.get('professeurId')}]);
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "matricule", value: search },
        { key: "name", value: search },
        { key: "classe_id", value: this.classeListId },
        { key: "annee_scolaire_id", value: this.anneeScolaireId }
      ];
      this.$store.dispatch("getElevesByClasseId", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchEleve() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(absenceId = null) {
      this.showModal = true;
      this.absenceid = absenceId;
    },
    getParams(search = null) {
      let response = null;
      if (search) {
        response = [{ key: "libelle", value: search }];
      } else {
        response = null;
      }
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
    changeClasse(classe){
        // console.log("check classe "+JSON.stringify(classe));
      if(classe == 0){
        this.$store.dispatch('classeId', null);
        this.titleDropdownClasse = "Classes";
        this.classeId = 0;
      }else{
        // console.log("check classe est "+ JSON.stringify(classe.classe.id));
        this.$store.dispatch('classeId', classe.classe.id);
        this.titleDropdownClasse = classe.classe.libelle ;
        this.classeId = classe.classe.id;
        this.$cookies.set('classeId', classe.classe.id)
      }
    },
    refreshList(){
        if(this.classeListId && this.anneeScolaireId){
            this.fetch();
        }
    }
  },
  computed: {
    eleves() {
      this.countEleves = this.$store.getters.eleves.length;
      this.countEleves = this.countEleves > 0;
      return this.$store.getters.eleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    classeListId() {
      return this.$store.getters.classeId;
    },
    classes () {
      if(this.$store.getters.classes && this.$store.getters.classes[0] && this.$store.getters.classes[0].classe){
        this.$cookies.set('classeId', this.$store.getters.classes[0].classe.id)
      }
      return this.$store.getters.classes
    },
    anneeScolaireId(){
        return this.$store.getters.anneeScolaireId ? this.$store.getters.anneeScolaireId :
        this.$cookies.get('anneeScolaireId');
    },
    currentPage(){
      return this.$store.getters.currentPage;
    },
    countPage(){
      return this.$store.getters.countPage;
    },
    totalElement(){
      return this.$store.getters.totalElement;
    }
  },
  watch: {
    classeListId() {
    console.log("la valeur >> "+ this.anneeScolaireId);
      // this.fetch();
      this.refreshList();
    },
    classes(){
        if(this.classes){
      this.titleDropdownClasse = this.classes[0].classe.libelle;
      this.$store.dispatch('classeId', this.classes[0].classe.id);
        }
    },
    anneeScolaireId(){
        // console.log(this.sectionAnneeScolaireId);
        // this.fetch();
        this.refreshList();
    }
  }
};
</script>

<style>
  li { list-style-type: none}
</style>
