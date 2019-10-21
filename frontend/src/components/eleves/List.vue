<template>
  <div class="container">
    <h1>Liste des élèves</h1>
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
            disabled
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
        <table class="table">
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

        <!--<modal v-if="showModal" @close="showModal = false" v-bind:modelid="absenceid" modelname="eleve"></modal>-->

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
      if (search) {
        this.$store.dispatch("getElevesByClasseId", {
          payload: pageNum,
          search: [{ key: "libelle", value: search }]
        });
      } else {
        this.$store.dispatch("getElevesByClasseId", {
          payload: pageNum,
          search: null
        });
      }
    },
    searchEleve() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(absenceId = null) {
      this.showModal = true;
      this.absenceid = absenceId;
    }
  },
  computed: {
    eleves() {
      return this.$store.getters.eleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    }
  }
};
</script>
