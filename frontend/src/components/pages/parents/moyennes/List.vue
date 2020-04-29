<template>
  <div class="content">
    <div class="container-fluid">
      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#/">Accueil</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Moyennes
          </li>
        </ol>
      </nav>

      <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color: #fff; height: 42px">
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{active:selected == 1}"
              id="user-connexion"
              data-toggle="tab"
              href="javascript:void(0)"
              @click="selected = 1"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            >Liste des moyennes des matieres</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{active:selected == 2}"
              @click="selected = 2"
              id="classes"
              data-toggle="tab"
              href="javascript:void(0)"
              role="tab"
              aria-controls="profile"
              aria-selected="false"
            >Liste des moyennes de sections</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{active:selected == 3}"
              @click="selected = 3"
              id="classes"
              data-toggle="tab"
              href="javascript:void(0)"
              role="tab"
              aria-controls="profile"
              aria-selected="false"
            >La moyennes annuelle</a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <br />

          <!-- Liste des moyennes des matieres -->
          <div
            class="tab-pane fade"
            :class="{show:selected == 1,active:selected == 1}"
            id="home"
            role="tabpanel"
            aria-labelledby="user-connexion"
          >
              <div class="card">
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
                      <!--
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
                      </div>-->
                    </div>

                    <table class="table table-d">
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
                        <td scope="row">{{ index + 1}}</td>
                        <td>{{ moyenne.matiere.libelle }}</td>
                        <td>{{ formatMoyenne(moyenne.valeur) }} / 20</td>
                        <td>{{ moyenne.coefficient_matiere }}</td>
                        <td>
                          {{ formatMoyenne(moyenne.valeur * moyenne.coefficient_matiere) }} /
                          {{ moyenne.coefficient_matiere * 20 }}</td>
                        <td>{{ moyenne.rang }}</td>
                        <td>
                          <div class="row">
                            <!--<a :href="'#/moyennes/preview/'+moyenne.id" class="col">
                              <i class="fa fa-eye fa-lg"></i>
                            </a>-->
                            <a :href="'#/moyennes/preview/'+moyenne.id" class="btn btn-icon btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr v-if="!countMoyennes">
                        <td colspan="6" style="text-align: center;">Aucun enregistrement trouvé !</td>
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
                    <!--<div class="float-right pagi" v-if="pageCount > 1">
                      <paginate
                        :page-count="pageCount"
                        :click-handler="fetch"
                        :prev-text="'&laquo;'"
                        :next-text="'&raquo;'"
                        :container-class="'pagination'"
                      ></paginate>
                    </div>-->

                    <!--<a v-if="seeBtnValidation" class="btn btn-primary" @click="validate">valider</a>-->
                    <ul v-if="rapportvalidation">
                      <li>Date de création : {{ rapportvalidation.created_at }}</li>
                      <li>Description : {{ rapportvalidation.description }}</li>
                    </ul>

                    <!--<span>Ces moyennes sont des moyennes provisoires en attendant la validation par le comité .</span>
                    <span>Ces moyennes ont été validées par le comité le 12/04/2018 08:07/00</span>-->
                    <span>{{ showMessageForMoyenneMatieres() }}</span>
                  </div>
                </div>
              </div>
          </div>

          <!-- Liste des moyennes de sections -->
          <div
            class="tab-pane fade"
            :class="{show:selected == 2,active:selected == 2}"
            id="profile"
            role="tabpanel"
            aria-labelledby="classes"
          >
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <!-- Zone de recherche -->

                      <table class="table table-d">
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
                          <td scope="row">{{ index + 1}}</td>
                          <td><span v-if="moyenneSection.sectionanneescolaire">{{ moyenneSection.sectionanneescolaire.libelle }}</span></td>
                          <td> {{ moyenneSection.valeur }}</td>
                          <td>{{ moyenneSection.sectionanneescolaire.coefficient }}</td>
                          <td> <span v-if="moyenneSection.sectionanneescolaire">{{ moyenneSection.valeur * moyenneSection.sectionanneescolaire.coefficient }} </span></td>
                          <td>{{ moyenneSection.rang }}</td>
                        </tr>
                        <tr v-if="!countMoyennesSections">
                          <td colspan="6" style="text-align: center;">Aucun enregistrement trouvé !</td>
                          <td></td>
                        </tr>
                        </tbody>
                      </table>

                      <!--<a v-if="seeBtnValidation" class="btn btn-primary" @click="validate">valider</a>-->
                      <ul v-if="rapportvalidation">
                        <li>Date de création : {{ rapportvalidation.created_at }}</li>
                        <li>Description : {{ rapportvalidation.description }}</li>
                      </ul>

                      <span>{{ showMessageForMoyennesSections() }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- La moyenne annuelle -->
          <div
            class="tab-pane fade"
            :class="{show:selected == 3,active:selected == 3}"
            id="profile"
            role="tabpanel"
            aria-labelledby="classes"
          >
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <!-- Zone de recherche -->

                      <table class="table table-d">
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
                          <td scope="row">1</td>
                          <td><span v-if="moyenneAnnuelle.anneescolaire">{{ moyenneAnnuelle.anneescolaire.libelle }}</span></td>
                          <td> {{ moyenneAnnuelle.valeur }}</td>
                          <td> {{ moyenneAnnuelle.rang }}</td>
                        </tr>
                        <tr v-if="!moyenneAnnuelle">
                          <td colspan="3" style="text-align: center;">Aucun enregistrement trouvé !</td>
                          <td></td>
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
      </div>

    </div>
  </div>
</template>

<script>
import Axios from "axios";
import moment from 'moment'

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
      classeListId: null,
      selected: 1,
      isLoader: false
    };
  },
  created() {
    this.$store.dispatch('eleve', this.$cookies.get('eleveId'));
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "eleve_id", value: this.eleveListId },
        { key: "section_annee_scolaire_id", value: this.sectionAnneeScolaireId },
        { key: "type_moyenne_id", value: 2 }
      ];
      this.$store.dispatch("moyennes", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchMoyenneSection(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        // { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: this.eleveListId },
        { key: "annee_scolaire_id", value: this.$cookies.get('anneeScolaireId') },
        // { key: "section_annee_scolaire_id", value: this.$cookies.get('sectionAnneeScolaireId') },
        { key: "type_moyenne_id", value: 3 }
      ];
      
      this.$store.dispatch("moyennesSections", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
      // alert("chargement de la moyenne section")
    },
    fetchMoyenneAnuuelle(pageNum, search = null) {
        // console.log("==========================");
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        // { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: this.eleveListId },
        { key: "annee_scolaire_id", value: this.$cookies.get('anneeScolaireId') },
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
        { key: "annee_scolaire_id", value: this.$cookies.get('anneeScolaireId') }
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
        if(this.sectionAnneeScolaireId && this.eleveListId){
            this.fetch();
            this.fetchMoyenneSection();
            this.fetchMoyenneAnuuelle();
        }
    },
    changeSection(section){
        this.$store.dispatch('sectionAnneeScolaireId', section.id);
        this.titleDropdownSection = section.libelle ;
        // console.log("changement de la section libelle "+section.libelle);
        this.$cookies.set('sectionAnneeScolaireId', section.id);
        this.fetch();
    },
    showMessageForMoyenneMatieres(){
      // console.log("moyennesSections => "+JSON.stringify(this.moyennesSections));
      let sectionAnneeScolaireId = this.sectionAnneeScolaireId;
      let search = null;
      if(this.moyennesSections){
        this.moyennesSections.find(function(element){
          // console.log("recherche de la section "+JSON.stringify(element)+", sectionAnneeScolaireId => "+sectionAnneeScolaireId);
          if(sectionAnneeScolaireId == element.section_annee_scolaire_id){
            // console.log("section => "+JSON.stringify(element));
            search = element.validated_at;
          }
        });
      }
      let msg = null;
      if(search){
        let date = search.split(" ")[0]
        let time = search.split(" ")[1]
        msg = "Ces moyennes ont été validées par le comité le "+moment(String(date)).format('DD/MM/YYYY')+" "+time+" .";
      }else{
        // msg = "Ces moyennes sont des moyennes provisoires en attendant la validation par le comité ."
      }
      return msg;
    },
    showMessageForMoyennesSections(){
      let msg = null;
      if(this.moyenneAnnuelle && this.moyenneAnnuelle.validated_at){
        let date = this.moyenneAnnuelle.split(" ")[0]
        let time = this.moyenneAnnuelle.split(" ")[1]
        msg = "Ces moyennes ont été validées par le comité le "+moment(String(date)).format('DD/MM/YYYY')+" "+time+" .";
      }
      return msg;
    },
    showMessageForMoyenneAnnuelle(){
      let msg = null;
      if(this.moyenneAnnuelle && this.moyenneAnnuelle.validated_at){
        let date = this.moyenneAnnuelle.split(" ")[0]
        let time = this.moyenneAnnuelle.split(" ")[1]
        msg = "La moyenne moyenne ont été validée par le comité le "+moment(String(date)).format('DD/MM/YYYY')+" "+time+" .";
      }
      return msg;
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
      // console.log("liste des moyennes de sections "+JSON.stringify(this.$store.getters.moyennesSections));
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
      // console.log("changement de la section annee scolaire "+JSON.stringify(this.$store.getters.sectionsanneescolaire));
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
          console.log(" l'id de la section est "+element.id)
        }else{
          console.log("ne change ");
          this.titleDropdownSection = sectionsanneescolaire[0].libelle;
        }
      }
      // console.log(" titleDropdownSection "+this.titleDropdownSection);
      return this.$store.getters.sectionsanneescolaire;
    }
  },
  watch: {
    eleve(){
        // console.log("l'id de la classe est "+this.eleve.classe_id);
        if(this.eleve){
          // this.classeListId = this.eleve.classe_id;
          this.refreshList();
        }
    },
    eleveListId(){
      this.refreshList();
    },
    sectionAnneeScolaireId(){
        // console.log(this.sectionAnneeScolaireId);
        // this.fetch();
        this.refreshList();
    }/*,
    sectionsanneescolaire(){
        if(this.sectionsanneescolaire){
            this.titleDropdownSection = this.sectionsanneescolaire[0].libelle;
        }
    }*/
  }
};
</script>

<style>
  li { list-style-type: none}
  .modal-container {width: 700px!important;}
</style>
