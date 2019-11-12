<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            v-model="searchkeys"
            placeholder="Rechercher un élève"
            aria-label="Recipient's username"
            aria-describedby="button-addon2"
          />
          <div class="input-group-append">
            <button
              class="btn btn-outline-secondary"
              id="button-addon2"
              v-on:click="searchEleve"
            >rechercher</button>
          </div>
        </div>
      </div>
      <!--<div class="col">
        <a :href="'/#/absences-eleves/add'" class="btn btn-primary">Ajouter une absence</a>
      </div>-->
    </div>
    <br />
    <div class="row">
      <div class="col-md-12">
        <card class="strpied-tabled-with-hover" body-classes="table-full-width table-responsive">
          <template slot="header">
            <h4 class="card-title">Liste des élèves</h4>
          </template>
          <div class="card-body table-full-width table-responsive">
            <table class="table table-hover table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Prénoms</th>
                  <th scope="col">Matricule</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody v-if="eleves">
                <tr v-for="(eleve, index) in eleves">
                  <th scope="row">{{ index + 1}}</th>
                  <td>{{ eleve.eleve.name }}</td>
                  <td>{{ eleve.eleve.matricule }}</td>
                  <td>
                    <!--<a :href="'/#/absence-eleve/'+absenceeleve.id" class="btn btn-primary">detail</a>-->

                    <a :href="'/#/eleves/preview/'+eleve.eleve.id" class="btn btn-primary">Voir</a>
                    <!--<a :href="'/#/absences-eleves/update/'+absenceeleve.id" class="btn btn-primary">Modifier</a>-->
                    <!--<button id="show-modal" @click="showModalF(absenceeleve.id)" class="btn btn-danger">Supprimer</button>-->
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
        </card>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "ListEleve",
  data() {
    return {
      msg: "Liste des élèves",
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
      {key: 'matricule', value: search},
      {key: 'name', value: search}, 
      {key: 'classe_id', value: this.classeListId }
      ];
      this.$store.dispatch("getElevesByClasseId", {
          payload: pageNum,
          search: this.trimSearch(params)
        });
    },
    searchEleve() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(absenceId = null) {
      this.showModal = true;
      this.absenceid = absenceId;
    },
    getParams(search = null){
      let response = null;
      if (search) {
        response = [{ key: "libelle", value: search }]
      } else {
        response = null
      }
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
    eleves() {
      return this.$store.getters.eleves;
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
