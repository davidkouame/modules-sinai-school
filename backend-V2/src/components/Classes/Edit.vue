<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="row card-body-header">
      <div class="col-sm-6">
      </div>
      
    </div>

        <div class="col-md-12 card-body-body" v-if="classe">
          <form v-on:submit="saveClasse">
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
                        <select v-model="classe.serie_id" class="form-control" >
                        <option value="">Sélectionnez une serie</option>
                        <option :value="serie.id" v-for="serie in series">{{ serie.libelle }}</option>
                        </select>
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
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Niveaux</label>
                        <!---->
                        <select v-model="classe.niveau_id" class="form-control" >
                        <option value="">Sélectionnez un niveau</option>
                        <option :value="niveau.id" v-for="niveau in niveaux">{{ niveau.libelle }}</option>
                        </select>
                        <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Année scolaire</label>
                        <!---->
                        <select v-model="classe.annee_scolaire_id" class="form-control" >
                        <option value="">Sélectionnez une année scolaire</option>
                        <option :value="anneescolaire.id" v-for="anneescolaire in anneesscolaires">{{ anneescolaire.libelle }}</option>
                        </select>
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
                            <div class="col-sm-12">
                                <div class="float-right">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <a :href="'/#/classes-matieres-professeurs/add/'+classe_id" class="btn btn-primary">Ajouter</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <table class="table table-d">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Matiere</th>
                                  <th scope="col">Professeur</th>
                                  <th scope="col">Coefficient</th>
                                  <th scope="col">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if=" classesprofesseursmatieres" v-for="(classeprofesseurmatiere, index) in  classesprofesseursmatieres">
                                  <th scope="row">{{ index + 1}}</th>
                                  <td>{{ classeprofesseurmatiere.matiere ? classeprofesseurmatiere.matiere.libelle : ''}}</td>
                                  <td>{{ classeprofesseurmatiere.professeur ? classeprofesseurmatiere.professeur.nom + ' '+classeprofesseurmatiere.professeur.prenom  : ''}}</td>
                                  <td>{{ classeprofesseurmatiere.coefficient }}</td>
                                  <td>
                                    <a :href="'/#/classes-matieres-professeurs/edit/'+classeprofesseurmatiere.id"  class="btn btn-icon btn-success btn-sm">
                                      <!----><i class="fa fa-edit"></i><!---->
                                    </a>&nbsp;
                                    <a id="show-modal" @click="showModalF(classeprofesseurmatiere.id)"  class="btn btn-icon btn-danger btn-sm">
                                      <!----><i class="fa fa-times"></i><!---->
                                    </a>
                                  </td>
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
                          <div class="col-sm-12">
                            <div class="float-right">
                              <div class="row">
                                <div class="col-md-4">
                                  <a :href="'/#/eleves-classes/add/'+classe_id"class="btn btn-primary">Ajouter</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <table class="table table-d">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Matricule</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-if="elevesclasses" v-for="(eleveclasse, index) in elevesclasses">
                                <th scope="row">{{ index + 1}}</th>
                                <td><a :href="'/#/classes-eleves/'+eleveclasse.id">{{ eleveclasse.eleve.matricule }}</a></td>
                                <td>{{ eleveclasse.eleve.name }}</td>
                                <td>{{ eleveclasse.eleve.surname }}</td>
                                <td>
                                  <a id="show-modal" @click="showModalRemoveEleve(eleveclasse.id)"  class="btn btn-icon btn-danger btn-sm">
                                    <!----><i class="fa fa-times"></i><!---->
                                  </a>
                                </td>
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
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary">Modifier</button>
                    </div> 
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>

import moment from 'moment'

export default {
  data() {
    return {
      title: "Modifier une classe",
      validated_at: "17/11/1973",
      selected: 1,
      classe_id: null,
      showModal: false,
      showModalRemoveEleveClasse: false,
      classeId: null,
      classeMatiereProfesseurId: null,
      eleveclasse_id: null
    };
  },
  created() {
  this.classe_id = this.$route.params.id
  // recuperation de l'année scolaire
    this.$store.dispatch("getClasse", {
      classeId: this.$route.params.id
    });
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
  computed:{
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
