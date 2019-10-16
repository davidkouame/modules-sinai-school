<template>
  <div class="container">
    <h1>Liste des absences élèves</h1>
    <div class="row">
      <div class="col">
        <div class="input-group mb-3">
          <input type="text" class="form-control" v-model="searchkeys" 
          placeholder="Rechercher une absence" aria-label="Recipient's username" 
          aria-describedby="button-addon2" disabled>
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" id="button-addon2" v-on:click="searchAbsenceEleve">rechercher</button>
          </div>
        </div>
      </div>
      <div class="col">
        <a :href="'/#/absences-eleves/add'" class="btn btn-primary">Ajouter une absence</a>
      </div>
    </div>
    <br>
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
          <tr v-if="absenceseleves" v-for="(absenceeleve, index) in absenceseleves">
              <th scope="row">{{ index + 1}}</th>
              <td>{{ absenceeleve.heure_debut_cours}}</td>
              <td>{{ absenceeleve.heure_fin_cours}}</td>
              <!-- <td>{{ noteeleve.note.created_at|formatDate }}</td> -->
              <td v-if="absenceeleve.raisonabsence">{{ absenceeleve.raisonabsence.libelle }}</td>
              <td v-else="absenceeleve.raisonabsence"></td>
              <td>
                  <!--<a :href="'/#/absence-eleve/'+absenceeleve.id" class="btn btn-primary">detail</a>-->

                <a :href="'/#/absences-eleves/preview/'+absenceeleve.id" class="btn btn-primary">Voir</a>
              <a :href="'/#/absences-eleves/update/'+absenceeleve.id" class="btn btn-primary">Modifier</a>
              <button id="show-modal" @click="showModalF(absenceeleve.id)" class="btn btn-danger">Supprimer</button>
              </td>
            </tr>
          </tbody>
        </table>

        <modal v-if="showModal" @close="showModal = false" v-bind:modelid="absenceid" modelname="absence"></modal>

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
  name: 'ListAbsence',
  data () {
    return {
      msg: 'Liste des absences',
      searchkeys: null,
      showModal: false,
      absenceid: null
    }
  },
  created () {
    this.fetch()
  },
  methods: {
    fetch (pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum
      if (search) {
        this.$store.dispatch('absenceseleves', {payload: pageNum, search: [{key: 'libelle', value: search} ]})
      } else {
        this.$store.dispatch('absenceseleves', {payload: pageNum, search: null})
      }
      // pageNum = pageNum == null ? 1:pageNum;
      // this.$store.dispatch("absenceseleves", {'pageNum': pageNum, 'eleveId': 6});
    },
    searchAbsenceEleve () {
      this.fetch(null, this.searchkeys)
    },
    showModalF (absenceId = null) {
      this.showModal = true
      this.absenceid = absenceId
    }
  },
  computed: {
    absenceseleves() {
      return this.$store.getters.absenceseleves;
    },
    pageCount () {
      return this.$store.getters.pageCount
    }
  }

}
</script>
