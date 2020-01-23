<template>
  <div class="container">
    <div>Detail de la matière</div>
    <h1>Detail de la matière</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a
          class="nav-link active"
          id="user-connexion"
          data-toggle="tab"
          href="#detailMatiere"
          role="tab"
          aria-controls="home"
          aria-selected="true"
        >Détail matière</a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="classes"
          data-toggle="tab"
          href="#informationProfesseur"
          role="tab"
          aria-controls="profile"
          aria-selected="false"
        >Information professeur</a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="parent-notes"
          data-toggle="tab"
          href="#notes"
          role="tab"
          aria-controls="profile"
          aria-selected="false"
        >Notes</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <br />

      <!-- Tab user connexion -->
      <div
        class="tab-pane fade show active"
        id="detailMatiere"
        role="tabpanel"
        aria-labelledby="user-connexion"
      >
        <form>
          <ul v-if="matiere">
            <li>Id : {{ matiere.id }}</li>
            <li>libelle : {{ matiere.libelle }}</li>
            <li>Description : {{ matiere.description }}</li>
            <li>Type de matière : {{ matiere.typematiere.libelle }}</li>
          </ul>
        </form>
      </div>

      <!-- Tab classes -->
      <div
        class="tab-pane fade"
        id="informationProfesseur"
        role="tabpanel"
        aria-labelledby="classes"
      >
        <form>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input v-model="username" type="text" class="form-control" disabled />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input v-model="email" type="text" class="form-control" disabled />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tel</label>
            <div class="col-sm-10">
              <input v-model="tel" type="text" class="form-control" disabled />
            </div>
          </div>
        </form>
      </div>

      <!-- Tab matiere notes  -->
      <div
        class="tab-pane fade"
        id="notes"
        role="tabpanel"
        aria-labelledby="parent-notes"
      >
        <form>
          <div class="row">
            <div class="col">
              <div class="input-group mb-3">
                <input type="text" class="form-control" v-model="searchkeys" placeholder="Rechercher une note" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" id="button-addon2" v-on:click="searchNote">rechercher</button>
                </div>
              </div>
            </div>
          </div>
          <br>
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
                  <tr v-if="notes" v-for="(note, index) in notes">
                    <th scope="row">{{ index + 1}}</th>
                    <td>{{ note.note.libelle }}</td>
                    <td>{{ note.note.created_at|formatDate }}</td>
                    <td>
                      <span v-if="note.note.typenote">{{ note.note.typenote.libelle }}</span>
                    </td>
                    <td>
                      <a :href="'#/notes/preview/'+note.note.id" class="btn btn-primary">Voir</a>
                    </td>
                  </tr>
                </tbody>
              </table>

              <!--<modal v-if="showModal" @close="showModal = false" v-bind:noteid="noteid"></modal>-->

              <paginate
                :page-count="pageCount"
                :click-handler="fetch"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
              ></paginate>
            </div>
          </div>
        </form>
      </div>
    </div>

    <a @click="$router.go(-1)" class="btn btn-primary">retour</a>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "DetailNote",
  data() {
    return {
      username: null,
      email: null,
      tel: null,
      note_id: 0,
      eleve_id: 1,
      elevenote: ""
    };
  },
  created() {
    this.created();
  },
  computed: {
    notes () {
      return this.$store.getters.notes
    },
    matiere() {
      return this.$store.getters.matiere;
    },
    eleveListId() {
      return localStorage.getItem("eleveId");
    },
    classesprofesseursmatieres() {
      return this.$store.getters.classesprofesseursmatieres;
    }
  },
  methods: {
    created() {
      this.$store.dispatch("matiere", this.$route.params.id);
      this.fetchClassesProfesseursMatieres();
      this.fetchMatiereNote();
    },
    fetchClassesProfesseursMatieres(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        // {key: 'parent_id', value: localStorage.getItem('parentId')},
        { key: "eleve_id", value: this.eleveListId },
        { key: "matiere_id", value: this.$route.params.id }
      ];
      this.$store.dispatch("classesprofesseursmatieres", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchMatiereNote (pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum
      let params = [
        {key: 'libelle', value: search},
        {key: 'eleve_id', value: this.eleveListId},
        {key: 'matiere_id', value: this.$route.params.id}
      ];
      this.$store.dispatch('allnotesparent', {payload: pageNum, search: this.trimSearch(params)})
    },
    trimSearch(searchs = null) {
      let params = [];
      for (var key in searchs) {
        if (searchs[key].value) {
          params.push({ key: searchs[key].key, value: searchs[key].value });
        }
      }
      return params;
    },
    searchNote () {
      this.fetchMatiereNote(null, this.searchkeys)
    }
  },
  watch: {
    classesprofesseursmatieres() {
      let professeur = this.classesprofesseursmatieres[0].professeur;
      this.username = professeur.nom;
      this.tel = professeur.tel;
      this.email = professeur.email;
      console.log(
        "classes professeurs classes" +
          JSON.stringify(this.classesprofesseursmatieres[0].professeur)
      );
    }
  }
};
</script>
