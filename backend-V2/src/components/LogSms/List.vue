<template>
  <card class="card" :title="title">
    <div class="row card-body-header">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-8">
        <div class="float-right">
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control search" placeholder="Rechercher un log" @keyup="searchModel" v-model="search">
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
            <th scope="col">Date de création</th>
            <th scope="col">Parent</th>
            <th scope="col">Téléphone parent</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="alllogsms" v-for="(log, index) in alllogsms">
            <th scope="row">{{ index + 1}}</th>
            <td>{{ log.created_at }}</td>
            <td>{{ log.parent.name+' '+log.parent.surname}}</td>
            <td>{{ log.tel }}</td>
            <td>
              <a :href="'/#/log-sms/preview/'+log.id" class="btn btn-icon btn-info btn-sm">
                <!----><i class="fa fa-user"></i><!---->
              </a>
            </td>
          </tr>
          <tr v-show="showEmptySentenceLog"><td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td></tr>
        </tbody>
      </table>
      
                <div class="row" v-if="pageCount > 1">
                  <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                    Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                  </div>
                  <div class="col-md-8">
                    <div class="float-right pagi">
                      <paginate
                        :page-count="pageCount"
                        :click-handler="dispatchLogSms"
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
      title: "Liste des logs sms",
      search: null
    };
  },
  created(){
    this.dispatchLogSms();
  },
  methods: {
    dispatchLogSms(pageNum, search = null){
      pageNum = pageNum == null ? 1 : pageNum
      let params = [{key: 'search', value: search}];
      this.$store.dispatch('getAllLogSms', 
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
    searchModel(){
      this.dispatchLogSms(1, this.search)
    },
    getDate(time){
      return time.split(" ")[0]
    },
    getTime(time){
      var times = time.split(" ")[1].split(":")
      return times[0]+":"+times[1]
    },
  },
  computed:{
    alllogsms(){
      return this.$store.getters.alllogsms
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
    showEmptySentenceLog(){
      return  this.notEmptyObject(this.alllogsms) == 0
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
