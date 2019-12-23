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
          <li class="breadcrumb-item active" aria-current="page">Liste des notes</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des notes</h4>
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
                                      placeholder="Rechercher une note"
                                      aria-label="Recipient's username"
                                      aria-describedby="button-addon2"
                                    />
                                    <div class="input-group-append search-parent">
                                      <button
                                        class="btn btn-outline-secondary"
                                        id="button-addon2"
                                        v-on:click="searchNote"
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
                      <th scope="col">Libellé</th>
                      <th scope="col">Date</th>
                      <th scope="col">Type de note</th>
                      <th scope="col">Classe</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countNotes" v-for="(note, index) in notes">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ note.libelle }}</td>
                      <td>{{ note.created_at|formatDate }}</td>
                      <td>
                        <span v-if="note.typenote">{{ note.typenote.libelle }}</span>
                      </td>
                      <td>{{ note.classe.libelle }}</td>
                      <td>
                        <div class="row">
                          <a :href="'/#/notes/preview/'+note.id" class="col">
                            <i class="fa fa-eye fa-lg"></i>
                          </a>
                          <a v-if="!note.rapport_validation_id" :href="'/#/notes/update/'+note.id" class="col">
                            <i class="fa fa-pencil fa-lg"></i>
                          </a>
                          <a v-if="!note.rapport_validation_id" id="show-modal" @click="showModalF(note.id)" class="col" style="cursor:pointer;color:#42d0ed">
                            <i class="fa fa-trash-o fa-lg"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="!countNotes">
                      <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <modal
                  v-if="showModal"
                  @close="showModal = false"
                  v-bind:modelid="noteid"
                  modelname="note"
                ></modal>

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
  name: "ListNote",
  data() {
    return {
      msg: "Liste des notes",
      searchkeys: null,
      showModal: false,
      noteid: null,
      countNotes: null,
      classeId: null,
      titleDropdownClasse: null
      // sectionAnneeScolaireId: localStorage.getItem('sectionAnneeScolaireId')
    };
  },
  created() {
    this.fetch();
    this.$store.dispatch('classes', [{'key': 'professeur_id',
    'value': localStorage.getItem('professeurId')}]);
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        { key: "classe_id", value: this.classeListId },
        { key: "professeur_id", value: localStorage.getItem('professeurId') },
        { key: "section_annee_scolaire_id", value: this.sectionAnneeScolaireId }
      ];
      this.$store.dispatch("allnotes", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchNote() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(noteId = null) {
      this.showModal = true;
      this.noteid = noteId;
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
      if(classe == 0){
        this.$store.dispatch('classeId', null);
        this.titleDropdownClasse = "Classes";
        this.classeId = 0;
      }else{
        this.$store.dispatch('classeId', classe.classe.id);
        this.titleDropdownClasse = classe.classe.libelle ;
        this.classeId = classe.classe.id;
      }
    },
    refreshList(){
        if(this.classeListId && this.sectionAnneeScolaireId){
            this.fetch();
        }
    }
  },
  computed: {
    notes() {
      this.countNotes = this.$store.getters.notes.length;
      this.countNotes = this.countNotes > 0;
      return this.$store.getters.notes;
    },
    allnoteseleves() {
      return this.$store.getters.noteseleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    classeListId() {
      return this.$store.getters.classeId;
    },
    classes () {
      return this.$store.getters.classes
    },
    sectionAnneeScolaireId(){
        return this.$store.getters.sectionAnneeScolaireId;
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
      // this.fetch();
      this.refreshList();
    },
    classes(){
      if(this.classes){
        this.titleDropdownClasse = this.classes[0].classe.libelle;
        this.$store.dispatch('classeId', this.classes[0].classe.id);
        }
    },
    sectionAnneeScolaireId(){
        // console.log(this.sectionAnneeScolaireId);
        // this.fetch();
        this.refreshList();
    }
  }
};
</script>
<style>
  .check{display: block !important}
  a .fa-check{display: none}
  li { list-style-type: none}
</style>
