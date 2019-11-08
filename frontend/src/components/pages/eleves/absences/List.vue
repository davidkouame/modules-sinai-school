<template>
  <div class="content">
    <div class="container-fluid">
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
import Axios from "axios";
import LTable from "@/components/Table.vue";
import Card from "@/components/Cards/Card.vue";
const tableColumns = ["Id", "Named", "Salary", "Country", "City"];
const tableData = [
  {
    id: 1,
    named: "Dakota Rice",
    salary: "$36.738",
    country: "Niger",
    city: "Oud-Turnhout"
  },
  {
    id: 2,
    named: "Minerva Hooper",
    salary: "$23,789",
    country: "Curaçao",
    city: "Sinaai-Waas"
  },
  {
    id: 3,
    named: "Sage Rodriguez",
    salary: "$56,142",
    country: "Netherlands",
    city: "Baileux"
  },
  {
    id: 4,
    named: "Philip Chaney",
    salary: "$38,735",
    country: "Korea, South",
    city: "Overland Park"
  },
  {
    id: 5,
    named: "Doris Greene",
    salary: "$63,542",
    country: "Malawi",
    city: "Feldkirchen in Kärnten"
  }
];

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
      absenceid: null,
      table1: {
        columns: [...tableColumns],
        data: [...tableData]
      },
      table2: {
        columns: [...tableColumns],
        data: [...tableData]
      }
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
        { key: "eleve_id", value: localStorage.getItem("eleveId") }
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
