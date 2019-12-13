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
            <a href="#/moyennes">Moyennes</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Liste des moyenne</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des moyennes</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <!-- Zone de recherche -->
                   
                <div class="row">
                    <div class="float-left col-2">
                        <base-dropdown v-bind:title="titleDropdownSection">
                            <a v-for="sectionanneescolaire in sectionsanneescolaire" class="dropdown-item" 
                                href="javascript:void(0)" @click="changeSection(sectionanneescolaire)">
                              {{ sectionanneescolaire.libelle }}
                            </a>
                        </base-dropdown>
                    </div>
                    <div class="float-right offset-md-7 col-6">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="searchkeys"
                                        placeholder="Rechercher une moyenne"
                                        aria-label="Recipient's username"
                                        aria-describedby="button-addon2"
                                    />
                                    <div class="input-group-append search-parent">
                                        <button
                                          class="btn btn-outline-secondary"
                                          id="button-addon2"
                                          v-on:click="searchMoyenne"
                                        >rechercher</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Matière</th>
                      <th scope="col">Moyenne</th>
                      <th scope="col">Coef.</th>
                      <th scope="col">Coef. * Moy.</th>
                      <th scope="col">Rang</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countMoyennes" v-for="(moyenne, index) in moyennes">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ moyenne.matiere.libelle }}</td>
                      <td>{{ formatMoyenne(moyenne.valeur) }} / 20</td>
                      <td>{{ moyenne.coefficient_matiere }}</td>
                      <td>
                           {{ formatMoyenne(moyenne.valeur * moyenne.coefficient_matiere) }} /  
                           {{ moyenne.coefficient_matiere * 20 }}</td>
                           <td>{{ moyenne.rang }}</td>
                      <td>
                        <div class="row">
                          <a :href="'/#/moyennes/preview/'+moyenne.id" class="col">
                            <i class="fa fa-eye fa-lg"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="!countMoyennes">
                      <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <modal
                  v-if="showModal"
                  @close="showModal = false"
                  v-bind:modelid="classeId"
                  modelname="classe"
                  modaltype="validationNotes"
                ></modal>

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

                <!--<a v-if="seeBtnValidation" class="btn btn-primary" @click="validate">valider</a>-->
                <ul v-if="rapportvalidation">
                    <li>Date de création : {{ rapportvalidation.created_at }}</li>
                    <li>Description : {{ rapportvalidation.description }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      
        <!-- Liste des moyennes trimestrielle -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des moyennes trimestrielle</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <!-- Zone de recherche -->

                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Matière</th>
                      <th scope="col">Moyenne</th>
                      <th scope="col">Coef.</th>
                      <th scope="col">Coef. * Moy.</th>
                      <th scope="col">Rang</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countMoyennesSections" v-for="(moyenneSection, index) in moyennesSections">
                      <th scope="row">{{ index + 1}}</th>
                      <td><span v-if="moyenneSection.sectionanneescolaire">{{ moyenneSection.sectionanneescolaire.libelle }}</span></td>
                      <td> {{ moyenneSection.valeur }}</td>
                      <td>{{ moyenneSection.sectionanneescolaire.coefficient }}</td>
                      <td> <span v-if="moyenneSection.sectionanneescolaire">{{ moyenneSection.valeur * moyenneSection.sectionanneescolaire.coefficient }} </span></td>
                       <td>{{ moyenneSection.rang }}</td>
                    </tr>
                    <tr v-if="!countMoyennesSections">
                      <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <!--<a v-if="seeBtnValidation" class="btn btn-primary" @click="validate">valider</a>-->
                <ul v-if="rapportvalidation">
                    <li>Date de création : {{ rapportvalidation.created_at }}</li>
                    <li>Description : {{ rapportvalidation.description }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Liste des moyennes annuelles -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des moyennes annuelles</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <!-- Zone de recherche -->

                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Matière</th>
                      <th scope="col">Moyenne</th>
                      <th scope="col">Rang</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="moyenneAnnuelle">
                      <th scope="row">1</th>
                      <td><span v-if="moyenneAnnuelle.anneescolaire">{{ moyenneAnnuelle.anneescolaire.libelle }}</span></td>
                      <td> {{ moyenneAnnuelle.valeur }}</td>
                      <td> {{ moyenneAnnuelle.rang }}</td>
                    </tr>
                  </tbody>
                </table>
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
  name: "ListMoyenne",
  data() {
    return {
      msg: "Liste des moyennes",
      searchkeys: null,
      showModal: false,
      countMoyennes: false,
      countMoyennesSections: false,
      classeId: null,
      titleDropdownSection: null,
      countAbsences: null,
      classeListId: null
    };
  },
  created() {
    // console/log("l'id de la classe est");
    // console.log("l'id de la classe est "+localStorage.getItem('eleveId'));
    // console.log("l'id de la classe est "+this.classeListId);
    // this.fetch();
    this.$store.dispatch('eleve', localStorage.getItem('eleveId'));
    // this.fetchSection();
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        // { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: this.eleveListId },
        { key: "section_annee_scolaire_id", value: this.sectionAnneeScolaireId },
        { key: "type_moyenne_id", value: 2 }
      ];
      // console.log("@@@@@@@@@@@@@@@@@@@@@");
      this.$store.dispatch("moyennes", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchMoyenneSection(pageNum, search = null) {
        // console.log("==========================");
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        // { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: this.eleveListId },
        { key: "annee_scolaire_id", value: localStorage.getItem('anneeScolaireId') },
        { key: "type_moyenne_id", value: 3 }
      ];
      this.$store.dispatch("moyennesSections", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchMoyenneSection(pageNum, search = null) {
        // console.log("==========================");
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        // { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: this.eleveListId },
        { key: "annee_scolaire_id", value: localStorage.getItem('anneeScolaireId') },
        { key: "type_moyenne_id", value: 3 }
      ];
      this.$store.dispatch("moyennesSections", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchMoyenneAnuuelle(pageNum, search = null) {
        // console.log("==========================");
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        // { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: this.eleveListId },
        { key: "annee_scolaire_id", value: localStorage.getItem('anneeScolaireId') },
        { key: "type_moyenne_id", value: 1 }
      ];
      this.$store.dispatch("moyenneAnnuelle", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchSection(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "annee_scolaire_id", value: localStorage.getItem('anneeScolaireId') }
      ];
      this.$store.dispatch("sectionsanneescolaire", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchMoyenne() {
      this.fetch(null, this.searchkeys);
    },
    trimSearch(searchs = null) {
       // console.log("les params recus pour le trim sont "+JSON.stringify(searchs));
       // console.log("l'id de la classe est en params "+this.classeListId);
      let params = [];
      for (var key in searchs) {
        if (searchs[key].value) {
          params.push({ key: searchs[key].key, value: searchs[key].value });
        }
      }
      return params;
    },
    formatMoyenne(moy){
        if(moy.toString().length==1){
            return '0'+moy;
        }else{
            return moy;
        }
    },
    validate(){
       // alert("hdbfhd");
      this.showModal = true;
      // this.validationNotes = 
      
    },
    showModalF(noteId = null) {
      this.showModal = true;
      this.validationNotes
    },
    refreshList(){
        // console.log(">>>>>>>>>>>>>>>>> "+this.sectionAnneeScolaireId);
        if(this.sectionAnneeScolaireId && this.eleveListId && this.classeListId){
            this.fetch();
            this.fetchMoyenneSection();
            this.fetchMoyenneAnuuelle();
        }
    },
    changeSection(section){
        this.$store.dispatch('sectionAnneeScolaireId', section.id);
        this.titleDropdownSection = section.libelle ;
        // this.sectionAnneeScolaireId = section.id;
        localStorage.setItem('sectionAnneeScolaireId', section.id);
        this.fetch();
    }
    
  },
  computed: {
    moyennes() {
      if(this.$store.getters.moyennes){
        this.countMoyennes = this.$store.getters.moyennes.length;
        this.countMoyennes = this.countMoyennes > 0;
      }
      // console.log("la liste de moyennes est de "+JSON.stringify(this.$store.getters.moyennes));
      return this.$store.getters.moyennes;
    },
    moyennesSections() {
      if(this.$store.getters.moyennesSections){
        this.countMoyennesSections = this.$store.getters.moyennesSections.length;
        this.countMoyennesSections = this.countMoyennesSections > 0;
      }
      // console.log(">>>>>>>>>>>>>>>>"+JSON.stringify(this.$store.getters.moyennesSections));
      return this.$store.getters.moyennesSections;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    moyenneAnnuelle() {
      return this.$store.getters.moyenneAnnuelle ? this.$store.getters.moyenneAnnuelle[0] : null;
    },
    classes () {
      return this.$store.getters.classes
    },
    rapportvalidation(){
        return this.$store.getters.rapportvalidation
    },
    seeBtnValidation(){
        // console.log("le rapport validation "+JSON.stringify(this.rapportvalidation));
        return this.countMoyennes > 0 && !this.rapportvalidation;
    },
    eleve(){
        return this.$store.getters.eleve;
    },
    eleveListId(){
      return this.$store.getters.eleveId
    },
    sectionAnneeScolaireId(){
        return this.$store.getters.sectionAnneeScolaireId;
    },
    sectionsanneescolaire(){
        console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
        if(this.$store.getters.sectionsanneescolaire && 
            this.$store.getters.sectionsanneescolaire.length > 0){
            this.titleDropdownSection = this.$store.getters.sectionsanneescolaire[0].libelle;
        }
        return this.$store.getters.sectionsanneescolaire;
    }
  },
  watch: {
    eleve(){
        // console.log("l'id de la classe est "+this.eleve.classe_id);
        this.classeListId = this.eleve.classe_id;
        this.refreshList();
    },
    eleveListId(){
      this.refreshList();
    },
    sectionAnneeScolaireId(){
        // console.log(this.sectionAnneeScolaireId);
        // this.fetch();
        this.refreshList();
    },
    sectionsanneescolaire(){
        
        if(this.sectionsanneescolaire){
            
            this.titleDropdownSection = this.sectionsanneescolaire[0].libelle;
        }

    }
  }
};
</script>

<style>
  li { list-style-type: none}
  .modal-container {width: 700px!important;}
</style>
