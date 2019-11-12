<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <a :href="'/#/absences/add'" class="btn btn-primary">Ajouter une absence</a>
      </div>
      <div class="row">
        <div class="col-12">
          <card class="strpied-tabled-with-hover" body-classes="table-full-width table-responsive">
            <template slot="header">
              <h4 class="card-title">Liste des absences élèves</h4>
            </template>
            <div class="card-body table-full-width table-responsive">
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
                    <td>qsdsq</td>
                    <td>
                      <a :href="'/#/absences/preview/'+absenceeleve.id" class="btn btn-primary">Voir</a>
                    </td>
                  </tr>
                </tbody>
              </table>

              <paginate
                :page-count="pageCount"
                :click-handler="fetch"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'">
              </paginate>
            </div>
          </card>
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
      el: "edd"
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