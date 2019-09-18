<template>
  <div id="app" class="container">
    <h1>Liste des absence des élèves</h1>
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Heure début de cours</th>
              <th scope="col">Heure fin de cours</th>
              <th scope="col">Raison absence</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="absenceseleves" v-for="absenceeleve in absenceseleves">
              <th scope="row">1</th>
              <td>{{ absenceeleve.heure_debut_cours}}</td>
              <td>{{ absenceeleve.heure_fin_cours}}</td>
              <!-- <td>{{ noteeleve.note.created_at|formatDate }}</td> -->
              <td v-if="absenceeleve.raisonabsence">{{ absenceeleve.raisonabsence.libelle }}</td>
              <td v-else="absenceeleve.raisonabsence"></td>
              <td>
                <a :href="'/#/absence-eleve/'+absenceeleve.id" class="btn btn-primary">detail</a>
              </td>
            </tr>
          </tbody>
        </table>

        <paginate
          :page-count="pageCount"
          :click-handler="fetch"
          :prev-text="'Prev'"
          :next-text="'Next'"
          :container-class="'pagination'"
        ></paginate>
      </div>
    </div>
  </div>
</template>

<script>
console.log("salut les gars");
export default {
  name: "AbsenceEleve",
  data() {
    return {
      el: "edd"
    };
  },
  created(){
      this.fetch()
  },
  methods: {
      fetch(pageNum) {
      pageNum = pageNum == null ? 1:pageNum;
      // this.$store.getters.userId
      this.$store.dispatch("absenceseleves", {'pageNum': pageNum, 'eleveId': 6});
      // this.$store.dispatch("absenceseleves", 6);
    }
  },
  computed: {
      absenceseleves() {
      return this.$store.getters.absenceseleves;
    },
    pageCount(){
      return this.$store.getters.pageCount;
    }
  }
};
</script>