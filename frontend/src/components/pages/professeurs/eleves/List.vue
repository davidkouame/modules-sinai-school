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
              <h4 class="card-title">Liste des élèves</h4>
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
                            <div class="col-md-1">
                                <div class="col-1 add-form">
                                    <a :href="'/#/notes/add'">
                                      <i class="fa fa-plus-circle fa-lg font-size-28"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-hover table-striped">
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
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ eleve.eleve.name }}</td>
                      <td>{{ eleve.eleve.matricule }}</td>
                      <td>
                        <!--<a :href="'/#/absence-eleve/'+absenceeleve.id" class="btn btn-primary">detail</a>-->

                        <a :href="'/#/eleves/preview/'+eleve.eleve.id" class="col">
                          <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <!--<a :href="'/#/absences-eleves/update/'+absenceeleve.id" class="btn btn-primary">Modifier</a>-->
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
                <div class="float-right pagi" v-if="pageCount > 1">
                    <paginate
                      :page-count="pageCount"
                      :click-handler="fetch"
                      :prev-text="'&laquo;'"
                      :next-text="'&raquo;'"
                      :container-class="'pagination'"
                    ></paginate>
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
      countAbsences: null
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "matricule", value: search },
        { key: "name", value: search },
        { key: "classe_id", value: this.classeListId }
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
    classes () {
      return this.$store.getters.classes
    },
    changeClasse(classe){
      if(classe == 0){
        this.$store.dispatch('classeId', null);
        this.titleDropdownClasse = "Classes";
        this.classeId = 0;
      }else{
        this.$store.dispatch('classeId', classe.classe.id);
        this.titleDropdownClasse = classe.classe.libelle ;
        this.classeId = classe.classe.id;
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
      return this.$store.getters.classes
    }
  },
  watch: {
    classeListId() {
      this.fetch();
    },
    classes(){
      this.titleDropdownClasse = this.classes[0].classe.libelle;
      this.$store.dispatch('classeId', this.classes[0].classe.id);
    }
  }
};
</script>

<style>
  li { list-style-type: none}
</style>
