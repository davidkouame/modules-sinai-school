<template>
  <div class="content">
    <div class="container-fluid">

      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb" v-if="!matiere_id">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/">Accueil</a></li>
          <li class="breadcrumb-item"><a href="#/notes">Notes</a></li>
          <li class="breadcrumb-item active" aria-current="page">Détail de note</li>
        </ol>
      </nav>


      <nav aria-label="breadcrumb" v-if="matiere_id">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#/">Accueil</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#/matieres">Matières</a>
          </li>
          <li class="breadcrumb-item">
            <a :href="'/#/matieres/preview/'+matiere_id">Détail de la matière</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Détail d'une note</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Détail de note</h4>
            </div>
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="First Name"
                        class="form-control"
                        type="text"
                        v-model="note.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coéfficient</label>
                      <!---->
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Last Name"
                        class="form-control"
                        type="text"
                        v-model="note.coefficient"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <!---->
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Home Address"
                        class="form-control"
                        type="text"
                        v-model="note.reference"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de création</label>
                      <!---->
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Home Address"
                        class="form-control"
                        type="text"
                        v-model="note.created_at"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>



                  </div>

                  <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea
                        name
                        id
                        cols="30"
                        rows="2"
                        aria-describedby="addon-right addon-left"
                        class="form-control"
                        disabled
                      >
                      {{ note.description }}
                  </textarea>
                      <!---->
                    </div>
                </div>
                  </div>
                  
                <div class="clearfix"></div>
                <a @click="$router.go(-1)" class="btn btn-danger float-right" style="background: #EE2D20;color: #fff;opacity: 1;">Retour</a>
              </form>
            </div>
            <!---->
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
      elevenote: '',
      matiere_id: null
    }
  },
  created () {
    this.matiere_id = this.$route.params.matiere_id;
    this.$store.dispatch('note', this.$route.params.id);
  },
  computed: {
    note () {
      return this.$store.getters.note
    }
  }
}
</script>
