<template>
  <div class="content">
    <div class="container-fluid">

          <!-- Fil d'ariane -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#/">Accueil</a>
          </li>
          <li class="breadcrumb-item active"  aria-current="page">
            <a href="#/matieres">
              Matières
            </a>
          </li>
          <li class="breadcrumb-item">
              Détail matière
          </li>
        </ol>
      </nav>

        <div>
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
                    >Détail matière</a>
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
                    >Information professeur</a>
                </li>
                <!--<li class="nav-item">
                    <a
                      class="nav-link"
                      :class="{active:selected == 3}"
                      @click="selected = 3"
                      id="classes"
                      data-toggle="tab"
                      href="javascript:void(0)"
                      role="tab"
                      aria-controls="profile"
                      aria-selected="false"
                    >Notes</a>
                </li>-->
            </ul>
            <div class="tab-content" id="myTabContent">
                <br />

                  <!-- Détail matière -->
                  <div
                    class="tab-pane fade"
                    :class="{show:selected == 1,active:selected == 1}"
                    id="home"
                    role="tabpanel"
                    aria-labelledby="user-connexion"
                  >
                      <div class="card">
                        <div class="card-body">
                            <form v-if="matiere">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Libellé</label>
                                    <div class="col-sm-10">
                                      <input v-model="matiere.libelle" type="text" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Type de matière</label>
                                    <div class="col-sm-10">
                                      <input v-model="matiere.typematiere.libelle" type="text" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Coefficient</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" v-model="coefficient" disabled />
                                    </div>
                                </div>
                                <!--<a @click="$router.go(-1)" class="float-right btn btn-danger">retour</a>-->
                            </form>
                        </div>
                      </div>
                  </div>

                <!-- Information professeur -->
                <div
                    class="tab-pane fade"
                    :class="{show:selected == 2,active:selected == 2}"
                    id="profile"
                    role="tabpanel"
                    aria-labelledby="classes"
                  >
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
                                <!--<a @click="$router.go(-1)" class="float-right btn btn-danger">retour</a>-->
                            </form>
                          </div>
                        </div>
                </div>

                <!-- Notes -->
                <!--<div
                    class="tab-pane fade"
                    :class="{show:selected == 3,active:selected == 3}"
                    id="profile"
                    role="tabpanel"
                    aria-labelledby="classes"
                  >
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                  <tr v-if="countNotes" v-for="(note, index) in notes">
                                                    <th scope="row">{{ index + 1}}</th>
                                                    <td>{{ note.note.libelle }}</td>
                                                    <td>{{ note.note.created_at|formatDate }}</td>
                                                    <td>
                                                      <span v-if="note.note.typenote">{{ note.note.typenote.libelle }}</span>
                                                    </td>
                                                    <td>
                                                        <a :href="'#/notes/preview/'+note.id">
                                                            <i class="fa fa-eye fa-lg"></i>
                                                        </a>
                                                    </td>
                                                  </tr>
                                                  <tr v-if="!countNotes">
                                                    <td colspan="4" style="text-align: center;">Aucun enregistrement trouvé !</td>
                                                    <td></td>
                                                  </tr>
                                                </tbody>
                                              </table>
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
                                        <a @click="$router.go(-1)" class="float-right btn btn-danger">retour</a>
                                    </form>
                                </div>
                            </div>
                </div>-->
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
      countNotes: false,
      classeId: null,
      coefficient: null
    };
  },
  created() {
    this.created();
  },
  computed: {
    notes () {
        this.countNotes = this.$store.getters.notes.length > 0;
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
      this.$store.dispatch("matiere", this.$route.params.id);
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
    },
    getCoefficientMatiere(){
        let coefficient = null;
        let classeId = this.classeId;
        if(classeId){
            this.matiere.classematiere.find(function(element){
                if(element.classe_id ==  classeId){
                    coefficient = element.coefficient;
                    // console.log(">>>>>>>>>>> "+JSON.stringify(element.coefficient));
                }
            })
            // console.log(">>>>>>>>>>> "+JSON.stringify(this.matiere.classematiere));
        }
        this.coefficient = coefficient;
    }
  },
  watch: {
    classesprofesseursmatieres() {
      let professeur = this.classesprofesseursmatieres[0].professeur;
      this.username = professeur.nom;
      this.tel = professeur.tel;
      this.email = professeur.email;
      this.classeId = this.classesprofesseursmatieres[0].classe_id;
      /*console.log(
        "classes professeurs classes" +
          JSON.stringify(this.classesprofesseursmatieres[0].classe_id)
      );*/
      this.getCoefficientMatiere();
    }
  }
};
</script>
