<template>
  <card class="card" :title="title">
    <div class="row card-body-header">
      <div class="col-sm-6">
      </div>
      <div class="col-sm-6">
        <div class="float-right">
          <div class="row">
            <div class="col-md-8">
              <input type="text" class="form-control search" placeholder="Rechercher une abonnement" @keyup="searchModel" v-model="search">
            </div>
            <div class="col-md-4">
              <a :href="'#/abonnements/add/'"class="btn btn-primary btn-add">Ajouter</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-sm-12 card-body-body">
      <table class="table table-d">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Référence</th>
            <th scope="col">Parent</th>
            <!--<th scope="col">Année scolaire</th>-->
            <th scope="col">Date de création</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="abonnements" v-for="(abonnement, index) in abonnements">
            <th scope="row">{{ indexPagnation + index + 1}}</th>
            <td>{{ abonnement.reference  }}</td>
            <td>{{ abonnement.parent ? abonnement.parent.name+' '+abonnement.parent.surname : '--' }}</td>
            <!--<td>{{ abonnement.anneescolaire ? abonnement.anneescolaire.libelle : '--' }}</td>-->
            <!--<td>{{ abonnement.created_at | formatDate }}</td>-->
            <td>{{ abonnement.created_at }}</td>
            <td>
              <a :href="'#/abonnements/preview/'+abonnement.id" class="btn btn-icon btn-info btn-sm">
                <!----><i class="fa fa-user"></i><!---->
              </a>&nbsp;
              <a :href="'#/abonnements/edit/'+abonnement.id"  class="btn btn-icon btn-success btn-sm">
                <!----><i class="fa fa-edit"></i><!---->
              </a>&nbsp;
              <a id="show-modal" @click="showModalF(abonnement.id)" type="button" class="btn btn-icon btn-danger btn-sm btn-delete">
                <!----><i class="fa fa-times"></i><!---->
              </a>
            </td>
          </tr>
          <tr v-show="showEmptySentenceAbonnement"><td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td></tr>
        </tbody>
      </table>

        <modal
                  v-if="showModal"
                  @close="showModal = false"
                  v-bind:modelid="abonnementId"
                  modelname="abonnement"
                  textBody="Voulez vous supprimez cet abonnement ?"
                  nameUrl="abonnements"
                ></modal>
      
                <div class="row" v-if="pageCount > 1">
                  <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                    Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                  </div>
                  <div class="col-md-8">
                    <div class="float-right pagi">
                      <paginate
                        :page-count="pageCount"
                        :click-handler="dispatchAbonnements"
                        :prev-text="'&laquo;'"
                        :next-text="'&raquo;'"
                        :container-class="'pagination'"
                        :page-class="'page-item'"
                      ></paginate>
                    </div>
                  </div>
                </div>

    </div>
  </card>
</template>
<script>
export default {
  data() {
    return {
      title: "Liste des abonnements",
      showModal: false,
      abonnementId: null,
      search: null,
      indexPagnation: 0
    };
  },
  created(){
    this.dispatchAbonnements();
  },
  methods: {
    dispatchAbonnements(pageNum, search = null){
      pageNum = pageNum == null ? 1 : pageNum
      let params = [{key: 'search', value: search}];
      this.$store.dispatch('getAbonnements', 
      {payload: pageNum, search: this.trimSearch(params)})
    },
    trimSearch(searchs = null){
      let params = [];
      for (var key in searchs) {
        console.log("type of "+typeof searchs[key].value)
        if(searchs[key].value){
          params.push({'key': searchs[key].key, 'value': searchs[key].value});
        }
      }
      return params;
    },
    showModalF(abonnementId = null) {
      this.showModal = true;
      this.abonnementId = abonnementId;
    },
    searchModel(){
      this.dispatchAbonnements(1, this.search)
    }
  },
  computed:{
    abonnements(){
      return this.$store.getters.abonnements
    },
    pageCount() {
      return this.$store.getters.pageCount;
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
    showEmptySentenceAbonnement(){
      return  this.notEmptyObject(this.abonnements) == 0
    }
  },
  watch:{
    currentPage(){
      this.indexPagnation = (this.currentPage-1) * 10;
    }
  }
};
</script>
<style>
  .form-control.search {
    border-right: 0 none;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    padding: 10px 10px 10px 10px;
    background-color:
    #fff;
    border: 1px solid
    #ddd;
        border-right-color: rgb(221, 221, 221);
        border-right-style: solid;
        border-right-width: 1px;
    border-right-color:
    rgb(221, 221, 221);
    border-right-style: solid;
    border-right-width: 1px;
    border-radius: 4px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    color:
    #66615b;
    line-height: normal;
    font-size: 14px;
  }

  .card-body-header .row{
    margin-right: 0px;
    margin-left: 0  px;
  }

  .card-body-body{
    padding-top: 20px;
  }

  .paginate active{
  z-index: 1;
  color: #fff;
  background-color: #8294a8;
}

.pagination .active a{
  z-index: 1;
  color: #fff !important;
  background-color: #8294a8 !important;
}

</style>
