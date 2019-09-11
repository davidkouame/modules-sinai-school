<template>
  <div class="container">
    <div>DetailNote {{ $route.params.id }}</div>
    <ul>
      <li>Id : {{ note.id }}</li>
      <li>libelle : {{ note.datenoteeffectue|formatDate }}</li>
      <li>description : {{ note.description }}</li>
      <li>Coefficient : {{ note.coefficient }}</li>
      <li>Référence : {{ note.reference }}</li>
      <li v-if="elevenote && elevenote.valeur">Valeur pour cette note est {{ elevenote.valeur }} </li>
      <li v-else>Pas de valeur</li>
    </ul>
  <a :href="'/#/notes'" class="btn btn-primary">retour</a>
  </div>
</template>

<script>
import Axios from 'axios'

export default {
  name: "DetailNote",
  data() {
    return {
      note: "",
      note_id: 0,
      eleve_id: 1,
      elevenote: ""
    };
  },
  mounted () {
    this.note_id = this.$route.params.id
    this.eleve_id = 1
     Axios
      .get('http://localhost/modules-sinai-school/backend/api/v1/note/'+this.note_id)
      .then(response => {
        this.note = response.data.data
      })
      .catch(error => {
        console.log(error)
        this.errored = true
      })
      .finally(() => this.loading = false)

      Axios
      .get('http://localhost/modules-sinai-school/backend/api/v1/noteeleves/?note_id='+this.note_id+'&eleve_id='+this.eleve_id)
      .then(response => {
        // this.note = response.data.data
        this.elevenote = response.data.data[0]
      })
      .catch(error => {
        console.log(error)
        this.errored = true
      })
      .finally(() => this.loading = false)
  }
};
</script>
