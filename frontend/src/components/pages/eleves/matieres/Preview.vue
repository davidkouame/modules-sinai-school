<template>
  <div class="content">
    <div class="container-fluid">
      <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#/">Accueil</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#/matieres">Matières</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Détail de la matière</li>
        </ol>
      </nav>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 1}"
            id="user-connexion"
            data-toggle="tab"
            href="javascript:void(0)"
            @click="selected = 1"
            role="tab"
            aria-controls="home"
            aria-selected="true"
          >Matière</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 2}"
            @click="selected = 2"
            id="classes"
            data-toggle="tab"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >Professeur</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="parent-notes"
            data-toggle="tab"
            :class="{active:selected == 3}"
            @click="selected = 3"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >Notes</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <br />

        <!-- Tab user connexion -->
        <div class="tab-pane fade" :class="{show:selected == 1,active:selected == 1}" id="detailMatiere" role="tabpanel">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <form>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Libellé</label>
                    <div class="col-sm-10">
                      <input v-model="matiere.libelle" type="text" class="form-control" disabled />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Type de matière</label>
                    <div class="col-sm-10">
                      <input
                        v-mdoel="matiere.typematiere.libelle"
                        type="text"
                        class="form-control"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                      <input v-model="matiere.description" type="text" class="form-control" disabled />
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab classes -->
        <div class="tab-pane fade" :class="{show:selected == 2,active:selected == 2}" id="informationProfesseur" role="tabpanel">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
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
            </div>
          </div>
        </div>

        <!-- Tab matiere notes  -->
        <div class="tab-pane fade" :class="{show:selected == 3,active:selected == 3}" role="tabpanel" >
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
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

                    <table class="table table-hover table-striped">
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
                          <td class="actions">
                            <a :href="'#/matieres/notes/'+matiere_id+'/preview/'+note.note.id">
                              <i class="fa fa-eye fa-lg"></i>
                            </a>
                          </td>
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
    </div>
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
      elevenote: "",
      selected: 1,
      searchkeys: null,
      matiere_id: null
    };
  },
  created() {
    this.created();
  },
  computed: {
    notes() {
      return this.$store.getters.notes;
    },
    matiere() {
      return this.$store.getters.matiere;
    },
    eleveListId() {
      return this.$cookies.get("eleveId");
    },
    classesprofesseursmatieres() {
      return this.$store.getters.classesprofesseursmatieres;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    }
  },
  methods: {
    created() {
      this.matiere_id = this.$route.params.id;
      // console.log("l'id de la matiere est "+ matiere_id)
      this.$store.dispatch("matiere", this.matiere_id);
      this.fetchClassesProfesseursMatieres();
      this.fetchMatiereNote();
    },
    fetchClassesProfesseursMatieres(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        // {key: 'parent_id', value: this.$cookies.get('parentId')},
        { key: "eleve_id", value: this.eleveListId },
        { key: "matiere_id", value: this.$route.params.id }
      ];
      this.$store.dispatch("classesprofesseursmatieres", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
    },
    fetchMatiereNote(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      let params = [
        { key: "libelle", value: search },
        { key: "eleve_id", value: this.eleveListId },
        { key: "matiere_id", value: this.$route.params.id }
      ];
      this.$store.dispatch("allnotesparent", {
        payload: pageNum,
        search: this.trimSearch(params)
      });
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
    searchNote() {
      this.fetchMatiereNote(null, this.searchkeys);
    },
    changeTab(tab) {
      alert("le tab choisir est " + tab);
    },
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
    }
  },
  watch: {
    classesprofesseursmatieres() {
      let professeur = this.classesprofesseursmatieres[0].professeur;
      this.username = professeur.nom;
      this.tel = professeur.tel;
      this.email = professeur.email;
    }
  }
};
</script>
