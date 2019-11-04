<template>
  <div class="container">
    <h1>Liste des matières</h1>
    <div class="row">
      <div class="col">
        <div class="input-group mb-3">
          <input type="text" class="form-control" v-model="searchkeys" placeholder="Rechercher une matière" aria-label="Recipient's username" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" id="button-addon2" v-on:click="searchmatiere">rechercher</button>
          </div>
        </div>
      </div>
      <!--<div class="col">
        <a :href="'/#/matieres/add'" class="btn btn-primary">Ajouter une matiere</a>
      </div>-->
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Libellé</th>
            <th scope="col">Actions</th>
          </tr>
          </thead>
          <tbody v-if="eleveListId">
          <tr v-if="matieres" v-for="(matiere, index) in matieres">
            <th scope="row">{{ index + 1}}</th>
            <td>{{ matiere.libelle }}</td>
            <td>
              <a :href="'/#/matieres/preview/'+matiere.id" class="btn btn-primary">Voir</a>
            </td>
          </tr>
          </tbody>
          <tbody v-else>
            Aucun élève n'est séléctionné, veillez sélectionner un élève
          </tbody>
        </table>

        <!--<modal v-if="showModal" @close="showModal = false" v-bind:matiereid="matiereid"></modal>-->

        <modal v-if="showModal" @close="showModal = false" v-bind:modelid="matiereid" modelname="matiere"></modal>

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
import Axios from 'axios'

export default {
  name: 'Listmatiere',
  data () {
    return {
      msg: 'Liste des matieres',
      searchkeys: null,
      showModal: false,
      matiereid: null
    }
  },
  created () {
    this.fetch();
    // this.classeId = this.$store.getters.classeId;
  },
  methods: {
    fetch (pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum
      let params = [
        {key: 'libelle', value: search},
        {key: 'eleve_id', value: this.eleveListId},
        {key: 'parent_id', value: localStorage.getItem('parentId')},
        {key: 'classe_id', value: this.classeListId}
      ];
      this.$store.dispatch('matieres', {payload: pageNum, search: this.trimSearch(params)})
    },
    searchmatiere () {
      this.fetch(null, this.searchkeys)
    },
    showModalF (matiereId = null) {
      this.showModal = true
      this.matiereid = matiereId
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
    matieres () {
      return this.$store.getters.matieres
    },
    pageCount () {
      return this.$store.getters.pageCount
    }, 
    classeListId(){
      return this.$store.getters.classeId
    },
    eleveListId(){
      let eleveId = this.$store.getters.eleveId
      localStorage.setItem("eleveId", eleveId)
      return eleveId
    }
  },
  watch:{
    eleveListId(){
      localStorage.setItem("eleveId", this.eleveListId)
      this.fetch();
    }
  }
}
</script>
