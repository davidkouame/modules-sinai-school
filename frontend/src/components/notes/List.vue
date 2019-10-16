<template>
  <div class="container">
    <h1>Liste des notes</h1>
    <div class="row">
      <div class="col">
        <div class="input-group mb-3">
          <input type="text" class="form-control" v-model="searchkeys" placeholder="Rechercher une note" aria-label="Recipient's username" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" id="button-addon2" v-on:click="searchNote">rechercher</button>
          </div>
        </div>
      </div>
      <div class="col">
        <a :href="'/#/notes/add'" class="btn btn-primary">Ajouter une note</a>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Libellé</th>
            <th scope="col">Date</th>
            <th scope="col">Type de note</th>
            <th scope="col">Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="notes" v-for="(note, index) in notes">
            <th scope="row">{{ index + 1}}</th>
            <td>{{ note.libelle }}</td>
            <td>{{ note.created_at|formatDate }}</td>
            <td><span v-if="note.typenote">{{ note.typenote.libelle }}</span></td>
            <td>
              <a :href="'/#/notes/preview/'+note.id" class="btn btn-primary">Voir</a>
              <a :href="'/#/notes/update/'+note.id" class="btn btn-primary">Modifier</a>
              <button id="show-modal" @click="showModalF(note.id)" class="btn btn-danger">Supprimer</button>
            </td>
          </tr>
          </tbody>
        </table>

        <!--<modal v-if="showModal" @close="showModal = false" v-bind:noteid="noteid"></modal>-->

        <modal v-if="showModal" @close="showModal = false" v-bind:modelid="noteid" modelname="note"></modal>

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
  name: 'ListNote',
  data () {
    return {
      msg: 'Liste des notes',
      searchkeys: null,
      showModal: false,
      noteid: null
    }
  },
  created () {
    this.fetch()
  },
  methods: {
    fetch (pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum
      if (search) {
        this.$store.dispatch('allnotes', {payload: pageNum, search: [{key: 'libelle', value: search} ]})
      } else {
        this.$store.dispatch('allnotes', {payload: pageNum, search: null})
      }
      // [{key: 'classe_id', value: 10},{key: 'typenote_id', value: 1} ]
    },
    searchNote () {
      this.fetch(null, this.searchkeys)
    },
    showModalF (noteId = null) {
      this.showModal = true
      this.noteid = noteId
    }
  },
  computed: {
    notes () {
      return this.$store.getters.notes
    },
    allnoteseleves () {
      return this.$store.getters.noteseleves
    },
    pageCount () {
      return this.$store.getters.pageCount
    }
  }
}
</script>
