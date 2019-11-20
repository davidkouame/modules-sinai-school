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
              <h4 class="card-title">Liste des absences</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                
                <!-- Zone de recherche -->
                <div class="row float-right">
                  <!--<div class="col-10">
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
                  </div>-->
                  <div class="col-1 add-form">
                    <a :href="'/#/absences/add'">
                      <i class="fa fa-plus-circle fa-lg font-size-28"></i>
                    </a>
                  </div>
                </div>

                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Heure début de cours</th>
                      <th scope="col">Heure fin de cours</th>
                      <th scope="col">Raison absence</th>
                      <th scope="col">Eleve</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="absenceseleves" v-for="(absenceeleve, index) in absenceseleves">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ absenceeleve.heure_debut_cours}}</td>
                      <td>{{ absenceeleve.heure_fin_cours}}</td>
                      <td v-if="absenceeleve.raisonabsence">{{ absenceeleve.raisonabsence.libelle }}</td>
                      <td v-else="absenceeleve.raisonabsence"></td>
                      <td>{{ absenceeleve.eleve.matricule}}</td>
                      <td>
                        <div class="row">
                          <a :href="'/#/absences/preview/'+absenceeleve.id" class="col">
                            <i class="fa fa-eye fa-lg"></i>
                          </a>
                          <a :href="'/#/absences/update/'+absenceeleve.id" class="col">
                            <i class="fa fa-pencil fa-lg"></i>
                          </a>
                          <a id="show-modal" @click="showModalF(absenceeleve.id)" class="col" style="cursor:pointer;color:#42d0ed">
                            <i class="fa fa-trash-o fa-lg"></i>
                          </a>
                        </div>
                      </td>
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
export default {
  name: "AbsenceEleve",
  data() {
    return {
      el: "edd",
      absenceId: null,
      showModal: false
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch(pageNum) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [{key: 'classe_id', value: this.classeListId}];
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
    }
  },
  computed: {
    absenceseleves() {
      return this.$store.getters.absenceseleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    }, 
    classeListId(){
      return this.$store.getters.classeId
    }
  },
  watch:{
    classeListId(){
      this.fetch();
    }
  }
};
</script>