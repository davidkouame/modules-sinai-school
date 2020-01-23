<template>
  <div class="content">
    <div class="container-fluid">

      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/">Accueil</a></li>
          <li class="breadcrumb-item"><a href="#/matieres">Matières</a></li>
          <li class="breadcrumb-item active" aria-current="page">Liste des matières</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des matières</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                
                <div class="float-right col-4" style="padding-right: 0px;">
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      v-model="searchkeys"
                      placeholder="Rechercher une matière"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                    />
                    <div class="input-group-append" style="height: 41px;">
                      <button
                        class="btn btn-outline-secondary"
                        id="button-addon2"
                        v-on:click="searchmatiere"
                      >rechercher</button>
                    </div>
                  </div>
                </div>

                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Libellé</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countMatieres" v-for="(matiere, index) in matieres">
                      <th scope="row">{{ index + 1}}</th>
                      <td>{{ matiere.libelle }}</td>
                      <td style="padding-left: 30px;">
                        <a :href="'#/matieres/preview/'+matiere.id">
                          <i class="fa fa-eye fa-lg"></i>
                        </a>
                      </td>
                    </tr>
                    <tr v-if="!countMatieres">
                      <td colspan="2" style="text-align: center;">Aucun resultat trouvé !</td>
                      <td></td>
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

export default {
  name: "Listmatiere",
  data() {
    return {
      msg: "Liste des matieres",
      searchkeys: null,
      showModal: false,
      matiereid: null,
      countMatieres: null
    };
  },
  created() {
    this.fetch();
    // this.classeId = this.$store.getters.classeId;
  },
  methods: {
    fetch(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        { key: "eleve_id", value: localStorage.getItem("eleveId") }
      ];
      this.$store.dispatch("matieres", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchmatiere() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(matiereId = null) {
      this.showModal = true;
      this.matiereid = matiereId;
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
    matieres() {
      // this.countMatieres = this.$store.getters.matieres.length
      this.countMatieres = this.$store.getters.matieres.length > 0;
      // console.log("liste des matieres "+this.countMatieres +"count est "+this.$store.getters.matieres.length)
      return this.$store.getters.matieres;
    },
    pageCount() {
      console.log("list" + this.$store.getters.pageCount)
      return this.$store.getters.pageCount;
    },
    classeListId() {
      return this.$store.getters.classeId;
    }
  }
};
</script>
