<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Détail de note</h4>
            </div>
            <div class="card-body" v-if="noteeleve && noteeleve.note">
              <form>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="First Name"
                        class="form-control"
                        type="text"
                        v-model="noteeleve.note.libelle"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coéfficient</label>
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Last Name"
                        class="form-control"
                        type="text"
                        v-model="noteeleve.note.coefficient"
                        disabled
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Home Address"
                        class="form-control"
                        type="text"
                        v-model="noteeleve.note.reference"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de création</label>
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Home Address"
                        class="form-control"
                        type="text"
                        v-model="noteeleve.note.created_at"
                        disabled
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Valeur</label>
                      <input
                        aria-describedby="addon-right addon-left"
                        class="form-control"
                        type="text"
                        v-bind:value="formatValeur(noteeleve.valeur)+'/20'"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coef x Val</label>
                      <input
                        aria-describedby="addon-right addon-left"
                        class="form-control"
                        type="text"
                        v-bind:value="formatValeur(noteeleve.note.coefficient * noteeleve.valeur)+'/'+noteeleve.note.coefficient*20"
                        disabled
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        aria-describedby="addon-right addon-left"
                        class="form-control"
                        disabled
                      >
                      {{ noteeleve.note.description }}
                  </textarea>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a @click="$router.go(-1)" class="btn btn-danger float-right">Retour</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    this.$store.dispatch('noteeleve', this.$route.params.id)
  },
  methods: {
    formatValeur(valeur){
      if(valeur.toString().length==1){
        return '0'+valeur;
      }else{
        return valeur;
      }
    }
  },
  computed: {
    noteeleve () {
      return this.$store.getters.noteeleve
    }
  }
}
</script>
