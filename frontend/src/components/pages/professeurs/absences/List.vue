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
            <a href="#/absences">Absences</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Liste des absences</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des absences </h4>
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
                            <div class="col-md-1">
                                <div class="col-1 add-form">
                                    <a :href="'#/absences/add'">
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
                      <th scope="col">Date</th>
                      <th scope="col">Heure début de cours</th>
                      <th scope="col">Heure fin de cours</th>
                      <th scope="col">Elèves</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countAbsences" v-for="(absenceeleve, index) in absenceseleves">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ getDate(absenceeleve.heure_debut_cours)|formatDate }}</td>
                      <td>{{ getTime(absenceeleve.heure_debut_cours) }}</td>
                      <td>{{ getTime(absenceeleve.heure_fin_cours) }}</td>
                      <td>{{ absenceeleve.eleve.name+' '+absenceeleve.eleve.surname}}</td>
                      <td>
                        <div class="row">
                          <a :href="'#/absences/preview/'+absenceeleve.id" class="col">
                            <i class="fa fa-eye fa-lg"></i>
                          </a>
                          <a :href="'#/absences/update/'+absenceeleve.id" class="col">
                            <i class="fa fa-pencil fa-lg"></i>
                          </a>
                          <a id="show-modal" @click="showModalF(absenceeleve.id)" class="col" style="cursor:pointer;color:#42d0ed">
                            <i class="fa fa-trash-o fa-lg"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="!countAbsences">
                      <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <modal
                  v-if="showModal"
                  @close="showModal = false"
                  v-bind:modelid="absenceId"
                  modelname="absence"
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
export default {
  name: "AbsenceEleve",
  data() {
    return {
      el: "edd",
      absenceId: null,
      showModal: false,
      classeId: null,
      titleDropdownClasse: null,
      countAbsences: null,
      searchkeys: null
      // sectionAnneeScolaireId: this.$cookies.get('sectionAnneeScolaireId')
    };
  },
  created() {
    // this.fetch();
    // this.sectionAnneeScolaireId = this.$cookies.get('sectionAnneeScolaireId');
    this.$store.dispatch('classes', [{'key': 'professeur_id',
      'value': this.$cookies.get('professeurId')}]);
  },
  methods: {
    fetch(pageNum, search = null) {
      // console.log("this.sectionAnneeScolaireId is "+ this.sectionAnneeScolaireId);
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        {key: 'search', value: search},
        {key: 'classe_id', value: this.classeListId},
        {key: 'section_annee_scolaire_id', value: this.sectionAnneeScolaireId }];
      this.$store.dispatch("absenceselevesP", { pageNum: pageNum,
      search: this.trimSearch(params) });
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
    showModalF(absenceId = null) {
      this.showModal = true;
      this.absenceId = absenceId;
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
            // console.log("classeListId "+JSON.stringify(this.classeListId)+", sectionAnneeScolaireId "+JSON.stringify(this.sectionAnneeScolaireId))
        }

    },
    getDate(time){
      return time.split(" ")[0]
    },
    getTime(time){
      var times = time.split(" ")[1].split(":")
      return times[0]+":"+times[1]
    },
    searchAbsence() {
      this.fetch(null, this.searchkeys);
    },
  },
  computed: {
    absenceseleves() {
      let absences = this.$store.getters.absenceseleves;
      if(absences){
        this.countAbsences = absences.length;
        this.countAbsences = this.countAbsences > 0;
        console.log("absenceseleves "+JSON.stringify(absences));
      }
      return absences;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    classeListId(){
      return this.$store.getters.classeId
    },
    classes () {
        // this.sectionAnneeScolaireId = 0;
        // this.sectionAnneeScolaireId = this.$store.getters.sectionAnneeScolaireId;
      return this.$store.getters.classes
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
  watch:{
    classeListId(){
      // this.fetch();
      this.refreshList();
    },
    classes(){
      if(this.classes){
        this.titleDropdownClasse = this.classes[0].classe.libelle;
        this.$store.dispatch('classeId', this.classes[0].classe.id);
      }
      this.refreshList();
      // this.sectionAnneeScolaireId = this.$store.getters.sectionAnneeScolaireId;
      // console.log("recuperation de la section de l'annee scolaire");
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
</style>
