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
                        <base-dropdown v-bind:title="titleDropdownClasse">
                            <a v-for="classe in classes" class="dropdown-item"
                                href="javascript:void(0)" @click="changeClasse(classe)">
                              {{ classe.classe.libelle }}
                              <i class="fa fa-check" :class="{check:classe.classe.id == classeId}" ></i>
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
                      <th scope="col">Mat. élève</th>
                      <th scope="col">Nom élève</th>
                      <th scope="col">Prénom élève</th>
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
                      <td>{{ moyenne.eleve.matricule }}</td>
                      <td>{{ moyenne.eleve.name }}</td>
                      <td>{{ moyenne.eleve.surname }}</td>
                      <td>{{ formatMoyenne(moyenne.valeur) }} / 20</td>
                      <td>{{ moyenne.coefficient_matiere }}</td>
                      <td>
                           {{ formatMoyenne(moyenne.valeur * moyenne.coefficient_matiere) }} /
                           {{ moyenne.coefficient_matiere * 20 }}</td>
                      <td>{{ moyenne.rang ? moyenne.rang : '--'  }}</td>
                      <td>
                        <div class="row">
                          <a :href="'#/moyennes/preview/'+moyenne.id" class="col">
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
      classeId: null,
      titleDropdownClasse: null,
      countAbsences: null,
      matiereId: null,
      // sectionAnneeScolaireId: this.$cookies.get('sectionAnneeScolaireId'),
    };
  },
  created() {
    this.refreshList();
    this.$store.dispatch('classes', [{'key': 'professeur_id',
    'value': this.$cookies.get('professeurId')}])
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "search", value: search },
        { key: "type_moyenne_id", value: 2 },
        { key: "classe_id", value: this.classeListId },
        { key: "professeur_id", value: this.$cookies.get('professeurId') },
        { key: "matiere_id", value: this.matiereId },
        { key: "section_annee_scolaire_id", value: this.sectionAnneeScolaireId }
      ];
      this.$store.dispatch("moyennesV2", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchMoyenne() {
      this.fetch(null, this.searchkeys);
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
      // this.matiereId = this.classes[0].matiere_id;
    },
    formatMoyenne(moy){
        if(moy){
          let moyenne = null;
          let moyennes = moy.toString().split(".");
          let partieEntiere = null;
          let partieDecimal = null;
          if(moyennes[0].toString().length==1){
            partieEntiere = '0'+moyennes[0];
          }else{
            partieEntiere = moyennes[0];
          }
          if(moyennes[1]){
            if(moyennes[1].length == 1){
              partieDecimal = moyennes[1]+"0";
            }else if(moyennes[1].length > 2){
              partieDecimal = moyennes[1].substr(0, 2);
            }
          }else{
            partieDecimal = "00";
          }
          return partieEntiere+"."+partieDecimal;
        }else{
          return "--"
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
        if(this.classeListId && this.sectionAnneeScolaireId){
            this.fetch();
        }
    }
  },
  computed: {
    moyennes() {
      if(this.$store.getters.moyennes){
        this.countMoyennes = this.$store.getters.moyennes.length;
        this.countMoyennes = this.countMoyennes > 0;
      }
      return this.$store.getters.moyennes;
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
    rapportvalidation(){
        return this.$store.getters.rapportvalidation
    },
    seeBtnValidation(){
        // console.log("le rapport validation "+JSON.stringify(this.rapportvalidation));
        return this.countMoyennes > 0 && !this.rapportvalidation;
    },
    sectionAnneeScolaireId(){
        // console.log("changement");
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
      // console.log("@@@@@@@@@@@@");
      // this.fetch();
      this.refreshList();
    },
    classes(){
        if(this.classes){
      this.titleDropdownClasse = this.classes[0].classe.libelle;
      this.$store.dispatch('classeId', this.classes[0].classe.id);
      this.classeId = this.classes[0].classe.id;
      // this.matiereId = this.classes[0].matiere_id;
       //console.log("la matiere de la classe est "+this.matiereId);
        // console.log("la matiere id est "+JSON.stringify(this.classes));
        }
    },
    classeId(){
        // this.$store.dispatch('getRapportValidationByClasseId', this.classes[0].classe.id);
    },
    matiereId(){
        // console.log("la matiere de la classe est "+this.matiereId);
        // this.fetch();
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
