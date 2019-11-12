<template>
  <div id="app" class="container">
    <h1>Modifier une note</h1>
    <form>
      <div class="form-group row">
        <label  class="col-sm-2 col-form-label">Libelle</label>
        <div class="col-sm-10">
        	<input type="text" class="form-control" v-model="libelle"/>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Date de note effectué </label>
        <div  class="col-sm-10">
        	<input type="date" class="form-control" v-model="datenoteeffectue"/>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Types notes</label>
        <div class="col-sm-10">
          <select v-model="typenote" class="form-control">
            <option value>Sélectionner un type de note</option>
            <option
              :value="typenote.id"
              v-for="typenote in typesnotes"
            >{{ typenote.libelle }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Classes</label>
        <div class="col-sm-10">
          <select v-model="classe" class="form-control" multiple="true" v-bind:class="{ 'fix-height': multiple === 'true' }">
            <option value>Sélectionner une ou plusieurs classes</option>
            <option
              :value="classeByProfesseur.classe.id"
              v-for="classeByProfesseur in classesByProfesseur"
            >{{ classeByProfesseur.classe.libelle }}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Coefficient </label>
        <div class="col-sm-10">
        	<input v-model="coefficient" type="number" class="form-control" />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
          <textarea v-model="description" class="form-control"></textarea>
        </div>
      </div>
      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
      <a v-on:click="createNote()" class="btn btn-primary">Modifier</a>
    </form>
  </div>
</template>

<script>

export default {
  name: 'UpdateNote',
  data () {
    return {
      typenote: null,
      description: null,
      libelle: null,
      datenoteeffectue: null,
      matiere: null,
      classe: [],
      coefficient: null,
      multiple: true
    }
  },
  created () {
    this.$store.dispatch('eleves')
    this.$store.dispatch('typesnotes')
    this.$store.dispatch('matieres')
    this.$store.dispatch('classesByProfesseur', localStorage.getItem('professeurId'))
    this.$store.dispatch('note', this.$route.params.id)
  },
  methods: {
    createNote () {
      const data = {}
      data['libelle'] = this.libelle
      data['datenoteeffectue'] = this.datenoteeffectue
      data['typenote_id'] = this.typenote
      data['classe_id'] = this.classe
      data['coefficient'] = this.coefficient
      data['id'] = this.$route.params.id
      data['description'] = this.description

      let store = this.$store
      store
        .dispatch('saveNote', data)
        .then(response => {
          // store.dispatch("raisonsabsences", response.data.data);
          alert('La modification de la note a été un succèss')
          // this.$router.push('/notes')
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    }
  },
  computed: {
    eleves () {
      return this.$store.getters.eleves
    },
    typesnotes () {
    	return this.$store.getters.typesnotes
    },
    matieres () {
    	return this.$store.getters.matieres
    },
    classesByProfesseur () {
      return this.$store.getters.classesByProfesseur
    },
    classeByProfesseur () {
      return this.$store.getters.classeByProfesseur
    },
    note () {
      return this.$store.getters.note
    }
  },
  watch: {
    note: function () {
      // console.log("nous avons changé la valeur de note "+JSON.stringify(this.note));
      if (this.note) {
        this.libelle = this.note.libelle
        this.typenote = this.note.typenote.id
        this.datenoteeffectue = this.note.datenoteeffectue.split(' ')[0] // this.note.datenoteeffectue;
        this.coefficient = this.note.coefficient
        this.description = this.note.description
        // this.classe = [1,2];
        // console.log(this.note.classe_id.split(','));
        this.classe = this.note.classe_id.split(',')
      }
    }
  }
}
</script>
