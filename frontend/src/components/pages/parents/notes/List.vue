<template>
  <div class="content">
    <div class="container-fluid">
    <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#/">Accueil</a>
          </li>
          <li class="breadcrumb-item active"  aria-current="page">
          Notes
          </li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <h4 class="card-title">Liste des notes {{ countNotes }}</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">

                <!-- Zone de recherche -->
                <div class="row">
                  <div class="float-left col-3" v-if="sectionsanneescolaire">
                    <base-dropdown v-bind:title="titleDropdownSection">
                      <a v-for="sectionanneescolaire in sectionsanneescolaire" class="dropdown-item"
                         href="javascript:void(0)" @click="changeSection(sectionanneescolaire)">
                        {{ sectionanneescolaire.libelle }}
                      </a>
                    </base-dropdown>
                  </div>
                  <div class="float-right col-9">
                    <div class="row">
                      <div class="offset-md-6 col-md-6">
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
                    </div>
                  </div>
                </div>

                <!-- Liste -->
                <table class="table table-d">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Libellé</th>
                      <th scope="col">Note</th>
                      <th scope="col">Coefficient</th>
                      <th scope="col">Coef x Val</th>
                      <th scope="col">Date</th>
                      <th scope="col">Type de note</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countNotes" v-for="(note, index) in notes">
                      <td scope="row">{{ index + 1}}</td>
                      <td><span v-if="note">{{ note.note.libelle }}</span></td>
                      <td><span v-if="note">{{ formatValeur(note.noteeleve.valeur) ?
                        formatValeur(note.noteeleve.valeur)+'/20': '--' }}</span></td>
                      <td><span v-if="note">{{ note.note.coefficient }}</span></td>
                      <td><span v-if="note">{{ formatValeur(note.noteeleve.valeur*note.note.coefficient) ?
                        formatValeur(note.noteeleve.valeur*note.note.coefficient)+'/'+note.note.coefficient*20 : '--'}}</span></td>
                      <td><span v-if="note">{{ note.note.created_at|formatDate }}</span></td>
                      <td>
                        <span v-if="note">{{ note.typenote.libelle }}</span>
                      </td>
                      <td class="actions">
                        <!--<a :href="'#/notes/preview/'+note.noteeleve.id">
                          <i class="fa fa-eye fa-lg"></i>
                        </a>-->
                        <a :href="'#/notes/preview/'+note.noteeleve.id" class="btn btn-icon btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      </td>
                    </tr>

                    <tr v-if="!countNotes">
                      <td colspan="7" style="text-align: center;">Aucun enregistrement trouvé !</td>
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
                        :active-class="'active'"
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
      countNotes: false,
      titleDropdownSection: null,
    };
  },
  created() {
    // this.fetch();
    // this.classeId = this.$store.getters.classeId;
    this.refreshList();
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "search", value: search },
        { key: "eleve_id", value: this.eleveListId },
        { key: "parent_id", value: this.$cookies.get("parentId") },
        { key: "section_annee_scolaire_id", value: this.sectionAnneeScolaireId }
      ];
      this.$store.dispatch("allnotesparentV3", {
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
    refreshList(){
        // console.log(">>>>>>>>>>>>>>>>> "+this.sectionAnneeScolaireId);
        if(this.sectionAnneeScolaireId && this.eleveListId){
            this.fetch();
        }
        // console.log("sectionAnneeScolaireId = "+this.sectionAnneeScolaireId+", eleveListId ="+this.eleveListId);
    },
    changeSection(section){
      this.$store.dispatch('sectionAnneeScolaireId', section.id);
      this.titleDropdownSection = section.libelle ;
      // this.sectionAnneeScolaireId = section.id;
      this.$cookies.set('sectionAnneeScolaireId', section.id);
      this.fetch();
    },
    formatValeur(valeur){
      if(valeur || valeur==0){
        if(valeur.toString().length==1){
          return '0'+valeur;
        }else{
          return valeur;
        }
      }else{
        return null;
      }
    },
    isEmpty(obj) {
      for(var key in obj) {
          if(obj.hasOwnProperty(key))
              return false;
      }
      return true;
    }
  },
  computed: {
    notes() {
      this.countNotes = !this.isEmpty(this.$store.getters.notes);
      // console.log(this.$store.getters.notes);
      // this.countNotes = this.$store.getters.notes.length > 0;
      // console.log("count "+!this.isEmpty(this.$store.getters.notes));
      // console.log("====== >"+JSON.stringify(this.$store.getters.notes))
      // this.countNotes = this.$store.getters.notes.length > 0;
      // var te = this.$store.getters.notes.length > 0;
      // console.log("le countNote est "+JSON.stringify(this.$store.getters.notes));
      // console.log("le countNote est "+te);
      // console.log("la liste des notes"+JSON.stringify(this.$store.getters.notes[0]))
      // console.log("liste des notes "+JSON.stringify(this.$store.getters.notes));
      return this.$store.getters.notes;
    },
    allnoteseleves() {
      return this.$store.getters.noteseleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    eleveListId() {
      return this.$store.getters.eleveId;
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
    },
    sectionsanneescolaire(){
      // console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
      let sectionsanneescolaire = this.$store.getters.sectionsanneescolaire;
      let sectionAnneeScolaireId = this.sectionAnneeScolaireId;
      if(sectionsanneescolaire && sectionsanneescolaire.length > 0){
        if(this.sectionAnneeScolaireId){
          let element = sectionsanneescolaire.find(function(element){
            if(element.id == sectionAnneeScolaireId){
              return element;
            }
          });
          this.titleDropdownSection = element.libelle;
        }else{
          this.titleDropdownSection = sectionsanneescolaire[0].libelle;
        }

      }
      return this.$store.getters.sectionsanneescolaire;
    }
  },
  watch: {
    eleveListId() {
      // this.fetch();
      this.refreshList();
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
  li { list-style-type: none}
  .modal-container {width: 700px!important;}
  
</style>
