<template>
  <card class="card" :title="title">
    <div class="row card-body-header">
      <div class="col-sm-6">
      </div>
      <div class="col-sm-6">
        <div class="float-right">
          <div class="row">
            <div class="col-md-8">
              <input type="text" class="form-control search" placeholder="Rechercher une classe" @keyup="searchModel" v-model="search">
            </div>
            <div class="col-md-4">
              <a :href="'#/classes/add/'"class="btn btn-primary">Ajouter</a>
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
            <th scope="col">Libellé</th>
            <th scope="col">Niveau</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="classes" v-for="(classe, index) in classes">
            <th scope="row">{{ index + 1}}</th>
            <td>{{ classe.reference}}</td>
            <td>{{ classe.libelle}}</td>
            <td>{{ classe.niveau ? classe.niveau.libelle : ''}}</td>
            <td>
              <a :href="'#/classes/preview/'+classe.id" class="btn btn-icon btn-info btn-sm">
                <!----><i class="fa fa-user"></i><!---->
              </a>&nbsp;
              <a :href="'#/classes/edit/'+classe.id"  class="btn btn-icon btn-success btn-sm">
                <!----><i class="fa fa-edit"></i><!---->
              </a>&nbsp;
              <a id="show-modal" @click="showModalF(classe.id)" type="button" class="btn btn-icon btn-danger btn-sm">
                <!----><i class="fa fa-times"></i><!---->
              </a>
            </td>
          </tr>
          <tr v-show="showEmptySentenceClasse"><td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td></tr>
        </tbody>
      </table>

        <modal
                  v-if="showModal"
                  @close="showModal = false"
                  v-bind:modelid="classeId"
                  modelname="classe"
                  textBody="Voulez vous supprimez cette classe ?"
                  nameUrl="classes"
                ></modal>
      
                <div class="row" v-if="pageCount > 1">
                  <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                    Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                  </div>
                  <div class="col-md-8">
                    <div class="float-right pagi">
                      <paginate
                        :page-count="pageCount"
                        :click-handler="dispatchClasses"
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
      title: "Liste des classes",
      showModal: false,
      classeId: null,
      search: null
    };
  },
  created(){
    this.dispatchClasses();
  },
  methods: {
    dispatchClasses(pageNum, search = null){
      pageNum = pageNum == null ? 1 : pageNum
      let params = [{key: 'search', value: search}];
      this.$store.dispatch('getClasses', 
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
    showModalF(classeId = null) {
      this.showModal = true;
      this.classeId = classeId;
    },
    searchModel(){
      this.dispatchClasses(1, this.search)
    }
  },
  computed:{
    classes(){
      return this.$store.getters.classes
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
    showEmptySentenceClasse(){
      return  this.notEmptyObject(this.classes) == 0
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
