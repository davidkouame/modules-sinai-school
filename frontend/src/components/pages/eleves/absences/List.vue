<template>
  <div class="content">
    <div class="container-fluid">

      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/">Accueil</a></li>
          <li class="breadcrumb-item"><a href="#/notes">Absences</a></li>
          <li class="breadcrumb-item active" aria-current="page">Liste des absences</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des absences élèves</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Heure début de cours</th>
                    <th scope="col">Heure fin de cours</th>
                    <th scope="col">Raison d'absence</th>
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
                    <td style="padding-left: 30px;">
                      <a :href="'#/absences/preview/'+absenceeleve.id">
                        <i class="fa fa-eye fa-lg"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>

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
import Axios from "axios";
import LTable from "@/components/Table.vue";
import Card from "@/components/Cards/Card.vue";

export default {
  name: "ListAbsence",
  components: {
    LTable,
    Card
  },
  data() {
    return {
      msg: "Liste des absences",
      searchkeys: null,
      showModal: false,
      absenceid: null
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        { key: "eleve_id", value: this.$cookies.get("eleveId") }
      ];
      this.$store.dispatch("getAbsenceseleves", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchAbsenceEleve() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(absenceId = null) {
      this.showModal = true;
      this.absenceid = absenceId;
    },
    trimSearch(searchs = null) {
      let params = [];
      for (var key in searchs) {
        if (searchs[key].value) {
          params.push({ key: searchs[key].key, value: searchs[key].value });
        }
      }
      return params;
    }
  },
  computed: {
    absenceseleves() {
      // console.log("liste d'absences "+this.$store.getters.absenceseleves)
      return this.$store.getters.absenceseleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    classeListId() {
      return this.$store.getters.classeId;
    }
  },
  watch: {
    classeListId() {
      this.fetch();
    }
  }
};
</script>