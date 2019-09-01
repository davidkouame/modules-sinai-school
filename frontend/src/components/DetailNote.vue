<template>
  <div class="container">
    <div>DetailNote {{ $route.params.id }}</div>
  </div>
</template>

<script>
import Axios from 'axios'

export default {
  name: "DetailNote",
  data() {
    return {
      msg: "Liste des notes",
      notes: [],
      note_id: $route.params.id
    };
  },
  mounted () {
    console.log(note_id)
     /*Axios
      .get('http://localhost:8888/modulesinaischool/backend/api/v1/notemodel/'+this.note_id)
      .then(response => {
        this.notes = response.data.data
        console.log(response.data.data)
      })
      .catch(error => {
        console.log(error)
        this.errored = true
      })
      .finally(() => this.loading = false)*/
  }
};
</script>
