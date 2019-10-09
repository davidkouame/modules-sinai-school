<template>
  <div class="container">
    <div>DetailNote {{ $route.params.id }}</div>
    <ul>
      <li>Id : {{ note.id }}</li>
      <li>libelle : {{ note.datenoteeffectue|formatDate }}</li>
      <li>description : {{ note.description }}</li>
      <li>Coefficient : {{ note.coefficient }}</li>
      <li>Référence : {{ note.reference }}</li>
    </ul>
    <a :href="'/#/notes'" class="btn btn-primary">retour</a>
  </div>
</template>

<script>
import Axios from 'axios'

export default {
  name: 'DetailNote',
  data () {
    return {
      note_id: 0,
      eleve_id: 1,
      elevenote: ''
    }
  },
  created () {
    this.$store.dispatch('note', this.$route.params.id)
  },
  computed: {
    note () {
      return this.$store.getters.note
    }
  }
}
</script>
