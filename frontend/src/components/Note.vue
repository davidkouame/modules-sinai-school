<template>
  <div class="container">
    <h1>Liste des notes</h1>

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
            <tr v-if="notes" v-for="note in notes">
              <th scope="row">1</th>
              <td>{{ note.libelle }}</td>
              <td>{{ note.created_at|formatDate }}</td>
              <td v-if="note.typenote">{{ note.typenote.libelle }}</td>
              <td v-else="note.typenote"></td>
              <td>
                <a :href="'/#/notes/'+note.id" class="btn btn-primary">detail</a>
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
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "Note",
  data() {
    return {
      msg: "Liste des notes"
    };
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch(pageNum) {
      pageNum = pageNum == null ? 1:pageNum;
      console.log(pageNum);
      this.$store.dispatch("allnotes", pageNum);
    }
  },
  computed: {
    notes() {
      return this.$store.getters.notes;
    },
    pageCount(){
      return this.$store.getters.pageCount;
    }
  }
};
</script>
