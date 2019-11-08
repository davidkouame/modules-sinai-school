<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="input-group mb-3">
            <input
              type="text"
              class="form-control"
              v-model="searchkeys"
              placeholder="Rechercher une note"
              aria-label="Recipient's username"
              aria-describedby="button-addon2"
            />
            <div class="input-group-append">
              <button
                class="btn btn-outline-secondary"
                id="button-addon2"
                v-on:click="searchNote"
              >rechercher</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <card class="strpied-tabled-with-hover" body-classes="table-full-width table-responsive">
            <template slot="header">
              <h4 class="card-title">Liste des notes</h4>
            </template>
            <div class="card-body table-full-width table-responsive">
              <table class="table table-hover table-striped">
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
                    <td>
                      <span v-if="note.typenote">{{ note.typenote.libelle }}</span>
                    </td>
                    <td>
                      <a :href="'/#/notes/preview/'+note.id" class="btn btn-primary">Voir</a>
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
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "ListNote",
  data() {
    return {
      msg: "Liste des notes",
      searchkeys: null,
      showModal: false,
      noteid: null
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
        { key: "classe_id", value: this.classeListId },
        { key: "eleve_id", value: localStorage.getItem("eleveId") }
      ];
      this.$store.dispatch("allnotes", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    searchNote() {
      this.fetch(null, this.searchkeys);
    },
    showModalF(noteId = null) {
      this.showModal = true;
      this.noteid = noteId;
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
    notes() {
      let notes = this.$store.getters.notes;
      return notes;
    },
    allnoteseleves() {
      return this.$store.getters.noteseleves;
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
