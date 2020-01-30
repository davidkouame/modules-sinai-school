<template>
  <div class="content">
    <div class="container-fluid">

      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/">Accueil</a></li>
          <li class="breadcrumb-item"><a href="#/notes">Notes</a></li>
          <li class="breadcrumb-item active" aria-current="page">Liste des notes</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">

            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Liste des notes</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">

                <!-- Zone de recherche -->
                <div class="float-right col-4" style="padding-right: 0px;">
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      v-model="searchkeys"
                      placeholder="Rechercher une note"
                      aria-label="Recipient's username"
                      aria-describedby="button-addon2"
                    />
                    <div class="input-group-append" style="height: 41px;">
                      <button
                        class="btn btn-outline-secondary"
                        id="button-addon2"
                        v-on:click="searchNote"
                      >rechercher</button>
                    </div>
                  </div>
                </div>

                <!-- Liste -->
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Libellé</th>
                      <th scope="col">Date</th>
                      <th scope="col">Type de note</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="countNotes" v-for="(note, index) in notes">
                      <td>{{ index + 1}}</td>
                      <td>{{ note.libelle }}</td>
                      <td>{{ note.created_at|formatDate }}</td>
                      <td>
                        <span v-if="note.typenote">{{ note.typenote.libelle }}</span>
                      </td>
                      <td style="padding-left: 30px;">
                        <a :href="'#/notes/preview/'+note.id">
                          <i class="fa fa-eye fa-lg"></i>
                        </a>
                      </td>
                    </tr>
                    <tr v-if="!countNotes">
                      <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
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
  name: "ListNote",
  data() {
    return {
      msg: "Liste des notes",
      searchkeys: null,
      showModal: false,
      noteid: null,
      countNotes: null
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
        { key: "eleve_id", value: this.$cookies.get("eleveId") }
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
      this.countNotes = this.$store.getters.notes.length;
      this.countNotes = this.countNotes > 0;
      return this.$store.getters.notes;
    },
    allnoteseleves() {
      return this.$store.getters.noteseleves;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    classeListId() {
      return this.$store.getters.classeId;
    },
    isNotes(){
      /*// let isNotes = this.notes && this.notes.length > 0;
      // let isNotes = this.notes.length > 0 ? new Boolean(true) : new Boolean(false);
      let isNotes = new Boolean(false);
      console.log(this.notes);
      return isNotes*/
      return true;
    }
  },
  watch: {
    classeListId() {
      this.fetch();
    }
  }
};
</script>
