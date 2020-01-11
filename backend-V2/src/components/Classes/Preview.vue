<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="classe">
                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="classe.reference"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Series</label>
                        <!---->
                        <input
                        class="form-control"
                        type="text"
                        v-bind:value="classe.serie ? classe.serie.libelle : ''"
                        disabled
                      />
                        <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="classe.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Niveau</label>
                        <!---->
                        <input
                        class="form-control"
                        type="text"
                        v-bind:value="classe.niveau ? classe.niveau.libelle : ''"
                        disabled
                      />
                        <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="classe.anneescolaire ? classe.anneescolaire.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a
                          class="nav-link"
                          id="user-connexion"
                          data-toggle="tab"
                          :class="{active:selected == 1}"
                          href="javascript:void(0)"
                          @click="selected = 1"
                          role="tab"
                          aria-controls="home"
                          aria-selected="true"
                        >Matières</a>
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
                        >Eleves</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-content" id="myTabContent">
                      <br />
                      <!-- Tab Matières -->
                      <div
                        class="tab-pane fade"
                        :class="{show:selected == 1,active:selected == 1}"
                        id="home"
                        role="tabpanel"
                        aria-labelledby="user-connexion">
                          <div class="col-12">
                            <table class="table table-d">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Matiere</th>
                                  <th scope="col">Professeur</th>
                                  <th scope="col">Coefficient</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if=" classesprofesseursmatieres" v-for="(classeprofesseurmatiere, index) in  classesprofesseursmatieres">
                                  <th scope="row">{{ index + 1}}</th>
                                  <td>{{ classeprofesseurmatiere.matiere ? classeprofesseurmatiere.matiere.libelle : ''}}</td>
                                  <td>{{ classeprofesseurmatiere.professeur ? classeprofesseurmatiere.professeur.nom + ' '+classeprofesseurmatiere.professeur.prenom  : ''}}</td>
                                  <td>{{ classeprofesseurmatiere.coefficient }}</td>
                                </tr>
                              </tbody>
                            </table>
                            <modal
                              v-if="showModal"
                              @close="showModal = false"
                              v-bind:modelid="classeMatiereProfesseurId"
                              modelname="classematiereprofesseur"
                              textBody="Voulez vous supprimez cette matière ?"
                              nameUrl="classesprofesseursmatieres">
                            </modal>
                          </div>
                      </div>
                      <!-- Tab élèves -->
                      <div
                        class="tab-pane fade"
                        :class="{show:selected == 2,active:selected == 2}"
                        id="profile"
                        role="tabpanel"
                        aria-labelledby="classes">
                        <div class="col-12">
                          <table class="table table-d">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Matricule</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-if="elevesclasses" v-for="(eleveclasse, index) in elevesclasses">
                                <th scope="row">{{ index + 1}}</th>
                                <td>{{ eleveclasse.eleve.matricule }}</td>
                                <td>{{ eleveclasse.eleve.name }}</td>
                                <td>{{ eleveclasse.eleve.surname }}</td>
                              </tr>
                              <tr v-show="showEmptySentenceEleveClasse"><td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td></tr>
                            </tbody>
                          </table>
                          <modal
                            v-if="showModalRemoveEleveClasse"
                            @close="showModalRemoveEleveClasse = false"
                            v-bind:modelid="eleveclasse_id"
                            modelname="classematiereprofesseur"
                            textBody="Voulez vous supprimez cet élève ?"
                            nameUrl="elevesclasses">
                          </modal>

                          <div class="row" v-if="pageCount > 1">
                            <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                              Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                            </div>
                            <div class="col-md-8">
                              <div class="float-right pagi">
                                <paginate
                                  :page-count="pageCount"
                                  :click-handler="dispatchElevesClasses"
                                  :prev-text="'&laquo;'"
                                  :next-text="'&raquo;'"
                                  :container-class="'pagination'"
                                  :page-class="'page-item'"
                                ></paginate>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/classes" class="btn btn-danger float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail classe",
      selected: 1,
      classe_id: null,
      showModal: false,
      showModalRemoveEleveClasse: false,
      classeId: null,
      classeMatiereProfesseurId: null,
      eleveclasse_id: null
    };
  },
  methods:{
    saveClasse(){
      let data = {
        libelle: this.classe.libelle,
        niveau_id: this.classe.niveau_id,
        serie_id: this.classe.serie_id,
        annee_scolaire_id: this.classe.annee_scolaire_id
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "classes", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    showModalF(classeMatiereProfesseurId = null) {
      this.showModal = true;
      this.classeMatiereProfesseurId = classeMatiereProfesseurId;
    },
    showModalRemoveEleve(eleveclasse_id = null){
      this.showModalRemoveEleveClasse = true;
      this.eleveclasse_id = eleveclasse_id;
    },
    dispatchElevesClasses(pageNum, search = null){
      pageNum = pageNum == null ? 1 : pageNum
      let params = [{key: 'search', value: search}, {key: 'classe_id', value: this.classe_id}];
      this.$store.dispatch('getElevesClasses', 
      {payload: pageNum, search: this.trimSearch(params)})
    },
    trimSearch(searchs = null){
      let params = [];
      for (var key in searchs) {
        console.log("type of "+typeof searchs[key].value)
        if(searchs[key].value){
          params.push({'key': searchs[key].key, 'value': searchs[key].value});
        }
      }
      return params;
    }
  },
  created() {
    this.$store.dispatch("getClasse", {
      classeId: this.$route.params.id
    });
    this.classe_id = this.$route.params.id
    // recuperation des niveaux
    this.$store.dispatch('getAllNiveaux', {payload: 0})
    // recuperation des series
    this.$store.dispatch('getAllSeries', {payload: 0})
    // recuperation de toutes les matieres d'une classe
    this.$store.dispatch('getMatieresByClasse', {classeId: this.$route.params.id})
    // recuperation de toutes les années scolaires
    this.$store.dispatch('getAllAnneesScolaires', {payload: 0})
    // recuperation de tous les eleves
    this.dispatchElevesClasses()
  },
  computed: {
    classe() {
      return this.$store.getters.classe;
    },
    niveaux(){
      return this.$store.getters.niveaux
    },
    series(){
      return this.$store.getters.series
    },
    classesprofesseursmatieres(){
      return this.$store.getters.classesprofesseursmatieres
    },
    anneesscolaires(){
      return this.$store.getters.anneesscolaires
    },
    elevesclasses(){
      return this.$store.getters.elevesclasses
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    currentPage(){
      return this.$store.getters.currentPage;
    },
    countPage(){
      return this.$store.getters.countPage;
    },
    totalElement(){
      return this.$store.getters.totalElement;
    },
    showEmptySentenceEleveClasse(){
      return  this.notEmptyObject(this.elevesclasses) == 0
    }
  }
};
</script>
