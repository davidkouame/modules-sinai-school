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
            Absences
          </li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <h4 class="card-title">Liste des absences</h4>
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
                            placeholder="Rechercher une absence"
                            aria-label="Recipient's username"
                            aria-describedby="button-addon2"
                          />
                          <div class="input-group-append search-parent">
                            <button
                              class="btn btn-outline-secondary"
                              id="button-addon2"
                              v-on:click="searchAbsence"
                            >rechercher</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>


                <!-- List -->
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Date</th>
                      <th scope="col">Heure début de cours</th>
                      <th scope="col">Heure fin de cours</th>
                      <th scope="col">Raison absence</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="absenceseleves" v-for="(absenceeleve, index) in absenceseleves">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ getDate(absenceeleve.heure_debut_cours)|formatDate }}</td>
                      <td>{{ getTime(absenceeleve.heure_debut_cours) }}</td>
                      <td>{{ getTime(absenceeleve.heure_fin_cours) }}</td>
                      <td v-if="absenceeleve.raisonabsence">{{ absenceeleve.raisonabsence.libelle }}</td>
                      <td v-else="absenceeleve.raisonabsence"></td>
                      <td class="actions">
                        <a :href="'#/absences/preview/'+absenceeleve.id">
                          <i class="fa fa-eye fa-lg"></i>
                        </a>
                      </td>
                    </tr>
                    <tr v-if="!countAbsences">
                      <td colspan="6" style="text-align: center;">Aucun enregistrement trouvé !</td>
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
import Axios from 'axios'

export default {
  name: 'ListAbsence',
  data () {
    return {
      msg: 'Liste des absences',
      searchkeys: null,
      showModal: false,
      absenceid: null,
      titleDropdownSection: null,
      countAbsences: null
    }
  },
  created () {
    this.refreshList()
  },
  methods: {
    fetch (pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum
      let params = [
      {key: 'search', value: search},
      {key: 'parent_id', value: this.$cookies.get('parentId')},
      {key: 'eleve_id', value: this.eleveListId},
        { key: "section_annee_scolaire_id", value: this.sectionAnneeScolaireId }];
      this.$store.dispatch('absenceselevesprofesseur',
      {payload: pageNum, search: this.trimSearch(params)})
    },
    searchAbsenceEleve () {
      this.fetch(null, this.searchkeys)
    },
    showModalF (absenceId = null) {
      this.showModal = true
      this.absenceid = absenceId
    },
    trimSearch(searchs = null){
      let params = [];
      for (var key in searchs) {
        if(searchs[key].value){
          params.push({'key': searchs[key].key, 'value': searchs[key].value});
        }
      }
      return params;
    },
    refreshList(){
        // console.log(">>>>>>>>>>>>>>>>> "+this.sectionAnneeScolaireId);
        if(this.sectionAnneeScolaireId && this.eleveListId){
            this.fetch();
        }
    },
    searchAbsence() {
      this.fetch(null, this.searchkeys);
    },
    getDate(time){
      return time.split(" ")[0]
    },
    getTime(time){
      var times = time.split(" ")[1].split(":")
      return times[0]+":"+times[1]
    },
    changeSection(section){
      this.$store.dispatch('sectionAnneeScolaireId', section.id);
      this.titleDropdownSection = section.libelle ;
      // this.sectionAnneeScolaireId = section.id;
      this.$cookies.set('sectionAnneeScolaireId', section.id);
      this.fetch();
    },
  },
  computed: {
    absenceseleves() {
      // console.log("liste d'absences "+this.$store.getters.absenceseleves)
      if(this.$store.getters.absenceseleves)
        this.countAbsences = this.$store.getters.absenceseleves.length > 0;
      return this.$store.getters.absenceseleves;
    },
    pageCount () {
      return this.$store.getters.pageCount
    },
    eleveListId(){
      return this.$store.getters.eleveId
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
      console.log("liste des sections annee scolaires est "+JSON.stringify(this.$store.getters.sectionsanneescolaire))
      return this.$store.getters.sectionsanneescolaire;
    }
  },
  watch:{
    eleveListId(){
      this.refreshList();
    },
    sectionAnneeScolaireId(){
        // console.log(this.sectionAnneeScolaireId);
        // this.fetch();
        this.refreshList();
    }
  }

}
</script>
