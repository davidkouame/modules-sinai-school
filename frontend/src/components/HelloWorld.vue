<template>
  <div class="container">
    <h1>{{ msg }}</h1>

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
            <tr v-for="note in notes">
              <th scope="row">1</th>
              <td>{{ note.libelle }}</td>
              <td>{{ note.created_at|formatDate }}</td>
              <td>{{ note.typenote.libelle }}</td>
              <td><a :href="'/#/notes/'+note.id" class="btn btn-primary">detail</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios'

export default {
  name: "HelloWorld",
  data() {
    return {
      msg: "Liste des notes",
      notes: []
    };
  },
  mounted () {
     Axios
      .get('http://localhost:8888/modulesinaischool/backend/api/v1/notemodel')
      .then(response => {
        this.notes = response.data.data
        console.log(response.data.data)
      })
      .catch(error => {
        console.log(error)
        this.errored = true
      })
      .finally(() => this.loading = false)
  }
};
</script>
