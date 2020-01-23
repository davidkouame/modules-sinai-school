<template>
  <div id="app" class="container">
    <h1>Liste des absences des élèves</h1>
    <a :href="'#/professeur/absenceseleves/add'" class="btn btn-primary">Ajouter une absence</a>
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Elève</th>
              <th scope="col">Heure début de cours</th>
              <th scope="col">Heure fin de cours</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="absenceseleves" v-for="absenceeleve in absenceseleves">
              <th scope="row">{{ absenceeleve.id }}</th>
              <td>
                <span v-if="absenceeleve.eleve">{{ absenceeleve.eleve.matricule }}</span>
                <span v-else="absenceeleve.eleve"></span>
              </td>
              <td>{{ absenceeleve.heure_debut_cours}}</td>
              <td>{{ absenceeleve.heure_fin_cours}}</td>
              <td>
                <a
                  :href="'#/professeur/absences-eleves/'+absenceeleve.id"
                  class="btn btn-primary"
                >detail</a>
                <a
                  :href="'#/professeur/absences-eleves/edit/'+absenceeleve.id"
                  class="btn btn-primary"
                >Modifier</a>
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
      this.$store.dispatch("absenceseleves", { pageNum: pageNum });
    }
  },
  computed: {
    absenceseleves() {
      return this.$store.getters.absenceseleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    }
  }
};
</script>