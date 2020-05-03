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
            <a href="#/eleves">Elèves</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Détailler une élève</li>
        </ol>
      </nav>

      <ul class="nav nav-tabs" id="myTab" role="tablist" style="background-color: #fff">
        <li class="nav-item">
          <a
            class="nav-link"
            data-toggle="tab"
            :class="{active:selected == 1}"
            href="javascript:void(0)"
            @click="selected = 1"
            role="tab"
            aria-controls="home"
            aria-selected="true"
          >Information de l'élève</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 2}"
            @click="selected = 2"
            data-toggle="tab"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >Information du parent</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 3}"
            @click="selected = 3"
            data-toggle="tab"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >Information notes</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 4}"
            @click="selected = 4"
            data-toggle="tab"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >Information absences</a>
        </li>
      </ul>

      <div class="tab-content" id="myTabContent">
        <br />

        <div
          class="tab-pane fade"
          :class="{show:selected == 1,active:selected == 1}"
          role="tabpanel"
          aria-labelledby="user-connexion"
        >
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <form>
                  <fieldset v-if="eleve">
                    <legend>Information de l'élève</legend>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nom</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" v-bind:value="eleve.name" disabled />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Prénoms</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.surname"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Matricule</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.matricule"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Date de naissance</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.datenaissance"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Téléphone</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" v-bind:value="eleve.tel" disabled />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.user.email"
                          disabled
                        />
                      </div>
                    </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div
          class="tab-pane fade"
          :class="{show:selected == 2,active:selected == 2}"
          role="tabpanel"
        >
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <form>
                  <fieldset v-if="parent">
                    <legend>Information du parent</legend>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nom</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.parent.name"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Prénoms</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.parent.surname"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Matricule</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.parent.matricule"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Date de naissance</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.parent.datenaissance"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Téléphone</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.parent.tel"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          class="form-control"
                          v-bind:value="eleve.parent.users.email"
                          disabled
                        />
                      </div>
                    </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div
          class="tab-pane fade"
          :class="{show:selected == 3,active:selected == 3}"
          role="tabpanel"
        >
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- Titre de la page -->
                <div class="card-header">
                  <h4 class="card-title">Information notes</h4>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <!-- Zone de recherche -->
                    <!--<div class="row float-right">
                      <div class="col-10">
                        <div class="input-group mb-3">
                          <input
                            type="text"
                            class="form-control"
                            v-model="searchkeys"
                            placeholder="Rechercher une note"
                            aria-label="Recipient's username"
                            aria-describedby="button-addon2"
                          />
                          <div class="input-group-append search-parent">
                            <button
                              class="btn btn-outline-secondary"
                              id="button-addon2"
                              v-on:click="searchNote"
                            >rechercher</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-1 add-form">
                        <a :href="'#/notes/add'">
                          <i class="fa fa-plus-circle fa-lg font-size-28"></i>
                        </a>
                      </div>
                    </div>-->

                    <table class="table table-d">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Libellé</th>
                          <th scope="col">Date</th>
                          <th scope="col">Type de note</th>
                          <th scope="col">Valeur</th>
                          <th scope="col">Coef.</th>
                          <th scope="col">Coef. * Valeur</th>
                          <th scope="col">Rang</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="countNotes" v-for="(note, index) in notes">
                          <td scope="row">{{ index + 1}}</td>
                          <td><a :href="'#/notes/preview/'+note.id" >{{ note.libelle }}</a></td>
                          <td>{{ note.created_at|formatDate }}</td>
                          <td> {{ note.type_note_libelle}} </td>
                          <!--<td v-bind:id="'note-'+note.id">{{ getValeur() }}</td>-->
                          <td>{{ formatValeur(note.valeur) ?
                        formatValeur(note.valeur)+'/20': '--' }}</td>
                          <td>{{ note.coefficient }}</td>
                          <!--<td>{{ formatMoyenne(note.coefficient*getValeur(index)) }} / {{ note.coefficient * 20 }}</td>-->
                          <td>{{ formatValeur(note.valeur*note.coefficient) ?
                        formatValeur(note.valeur*note.coefficient)+'/'+note.coefficient*20 : '--'}}</td>
                          <td>{{ note.rang ? note.rang : '--' }}</td>
                          <td>
                            <div class="row" style="margin-left: 16px">
                              <!--<a :href="'#/notes/preview/'+note.id" class="col">
                                <i class="fa fa-eye fa-lg"></i>
                              </a>-->
                              <!--<a :href="'#/notes/update/'+note.id" class="col">
                                <i class="fa fa-pencil fa-lg"></i>
                              </a>-->
                                <a
                                v-if="!note.rapport_validation_id"
                                id="show-modal"
                                @click="showModalF(note.id, 'note')"
                                :class="note.id"
                                class="col btn btn-icon btn-success btn-sm"
                                style="color: #fff"
                              >
                                <i class="fa fa-edit"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <tr v-if="!countNotes">
                          <td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>

                    <modal
                      v-if="showModal"
                      @close="showModal = false"
                      v-bind:modelid="noteid"
                      modelname="note"
                      modaltype="addValue"
                      v-bind:eleveId="eleveIdModal"
                    ></modal>

                    <!-- Pagination -->
                    <div class="float-right pagi" v-if="pageCountNote > 1">
                      <paginate
                        :page-count="pageCountNote"
                        :click-handler="fetchNote"
                        :prev-text="'&laquo;'"
                        :next-text="'&raquo;'"
                        :container-class="'pagination'"
                      ></paginate>
                    </div>
                    <span v-if="moyenneEleve">Moyenne : {{ formatMoyenne(moyenneEleve.valeur) }} / 20</span>
                    <!--<a class="btn btn-primary">valider</a>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="tab-pane fade"
          :class="{show:selected == 4,active:selected == 4}"
          role="tabpanel"
        >
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <!-- Titre de la page -->
                  <div class="card-header">
                    <h4 class="card-title">Information absences</h4>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">

                      <!-- Zone de recherche -->
                      <div class="row float-right">
                        <!--<div class="col-10">
                          <div class="input-group mb-3">
                            <input
                              type="text"
                              class="form-control"
                              v-model="searchkeys"
                              placeholder="Rechercher une absence"
                              aria-label="Recipient's username"
                              aria-describedby="button-addon2"
                              disabled
                            />
                            <div class="input-group-append search-parent">
                              <button
                                class="btn btn-outline-secondary"
                                id="button-addon2"
                                v-on:click="searchAbsenceEleve"
                              >rechercher</button>
                            </div>
                          </div>
                        </div>-->
                        <!--<div class="col-1 add-form">
                          <a :href="'#/absences/add'">
                            <i class="fa fa-plus-circle fa-lg font-size-28"></i>
                          </a>
                        </div>-->
                      </div>

                      <table class="table table-d">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Heure début de cours</th>
                            <th scope="col">Heure fin de cours</th>
                            <th scope="col">Raison absence</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-if="absenceseleves" v-for="(absenceeleve, index) in absenceseleves">
                            <td scope="row">{{ index + 1}}</td>
                            <td>{{ absenceeleve.heure_debut_cours}}</td>
                            <td>{{ absenceeleve.heure_fin_cours}}</td>
                            <!-- <td>{{ noteeleve.note.created_at|formatDate }}</td> -->
                            <td
                              v-if="absenceeleve.raisonabsence"
                            >{{ absenceeleve.raisonabsence.libelle }}</td>
                            <td v-else="absenceeleve.raisonabsence"></td>
                            <td>
                              <div class="row">
                                <a
                                  :href="'#/absences/preview/'+absenceeleve.id"
                                  class="col btn btn-icon btn-info btn-sm"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>&nbsp;
                                <a :href="'#/absences/update/'+absenceeleve.id" class="col btn btn-icon btn-success btn-sm">
                                  <i class="fa fa-edit"></i>
                                </a>&nbsp;
                                <a
                                  id="show-modal"
                                  @click="showModalF(absenceeleve.id, 'absence')"
                                  class="col btn btn-icon btn-danger btn-sm btn-delete"
                                  style="cursor:pointer;color:#42d0ed"
                                >
                                  <i class="fa fa-trash"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <modal
                        v-if="showModal"
                        @close="showModal = false"
                        v-bind:modelid="absenceid"
                        modelname="absence"
                      ></modal>

                      <!-- Pagination -->
                      <div class="row" v-if="pageCountAbsence > 1">
                        <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                          Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                        </div>
                        <div class="col-md-8">
                          <div class="float-right pagi">
                            <paginate
                              :page-count="pageCountAbsence"
                              :click-handler="fetchAbsence"
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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "DetailEleve",
  data() {
    return {
      searchkeys: null,
      showModal: false,
      eleveId: null,
      noteid: null,
      modelname: null,
      selected: 1,
      countNotes: null,
      eleveIdModal: null
    };
  },
  created() {
    this.eleveId = this.$route.params.id;
    this.$store.dispatch("eleveP", this.eleveId);
    this.fetchAbsence();
    this.fetchNote();
  },
  methods: {
    searchAbsenceEleve() {
      // this.fetch(null, this.searchkeys)
    },
    fetchAbsence(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      if (search) {
        this.$store.dispatch("absenceseleves", {
          payload: pageNum,
          search: [{ key: "libelle", value: search }],
          params: { eleveId: this.eleveId },
          eleveId: this.eleveId
        });
      } else {
        this.$store.dispatch("absenceseleves", {
          payload: pageNum,
          search: null,
          params: { eleveId: this.eleveId },
          eleveId: this.eleveId
        });
      }
    },
    fetchNote(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      if (search) {
        this.$store.dispatch("allnotesandvaleur", {
          payload: pageNum,
          search: [{ key: "libelle", value: search },
                  { key: "professeur_id", value: this.$cookies.get("professeurId") },
                  { key: "classe_id", value: this.$cookies.get("classeId") }
                  /*{ key: "eleve_id", value: this.$route.params.id }*/]
        });
      } else {
        this.$store.dispatch("allnotesandvaleurV2", {
          payload: pageNum,
          search: [{ key: "professeur_id", value: this.$cookies.get("professeurId") },
                  /*{ key: "eleve_id", value: this.$route.params.id }*/
                  { key: "classe_id", value: this.$cookies.get("classeId")}
                  ]
        });
      }
    },
    searchNote() {
      this.fetchNote(null, this.searchkeys);
    },
    showModalF(noteId = null, modelname = null, eleveId = null) {
      this.showModal = true;
      this.noteid = noteId;
      this.modelname = modelname;
      this.eleveIdModal = this.$route.params.id;
      console.log(">>>>>>> "+noteId);
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
    formatMoyenne(moy){
        if(moy.toString().length==1){
            return '0'+moy;
        }else{
            return moy;
        }
    },
    formatValeur(valeur){
      if(valeur){
        if(valeur.toString().length==1){
          return '0'+valeur;
        }else{
          return valeur;
        }
      }else{
        return null;
      }
    }/*,
    getValeur(index){
        let valeur = null
        if((this.valeurs && index) || (this.valeurs && index==0)){
            valeur = this.valeurs[index].valeur;
        }
        return 2*valeur;
    }*/
  },
  computed: {
    notes() {
      this.countNotes = this.$store.getters.notes ? this.$store.getters.notes.length : 0;
      this.countNotes = this.countNotes > 0;
      return this.$store.getters.notes;
    },
    absenceseleves() {
      return this.$store.getters.absenceseleves;
    },
    eleve() {
      return this.$store.getters.eleve;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    pageCountAbsence() {
      console.log("le page count absence est de "+this.$store.getters.pageCountAbsence);
      return this.$store.getters.pageCountAbsence;
    },
    pageCountNote() {
      return this.$store.getters.pageCountNote;
    },
    classesprofesseursmatieres() {
      return this.$store.getters.classesprofesseursmatieres;
    },
    parent() {
      let parent = this.eleve ? this.eleve.parent : null;
      return parent;
    },
    moyenneEleve(){
        return this.$store.getters.moyenne;
    },
    matiere(){
        return this.$store.getters.matiere;
    },
    valeurs(){
      return this.$store.getters.valeurs;
    },
    currentPage(){
      return this.$store.getters.currentPage;
    },
    countPage(){
      return this.$store.getters.countPage;
    },
    totalElement(){
      return this.$store.getters.totalElement;
    }
  },
  watch:{
    eleve: function() {
      /*this.$store.dispatch('getMatiereByProfesseurAndClasse', {"professeurId":
      this.$cookies.get("professeurId"),
      "classeId": this.eleve.classeseleves[0].classe_id});*/
    },
    matiere: function(){
        if(this.matiere){
        this.$store.dispatch("getMoyenneMatiere",
        {"eleveId":this.eleveId,"matiereId":this.matiere.id});}
    },
    valeurs(){
        let i = 0;
        //alert("nous avons des valeurs");
        console.log("liste des valeurs "+ JSON.stringify(this.valeurs));
        let th = this;
        var found = this.valeurs.find(function(element) {
            /*if(element.note_id == 20){
                return element;
            }*/
            var i = element.note_id;
            console.log("l'element id est "+JSON.stringify(document.getElementById("valeur-"+i)));
            if(document.getElementById("valeur-"+i)){
                document.getElementById("valeur-"+i).innerHTML = th.formatMoyenne(element.valeur) + '/20';
                var coefficient = document.getElementById("coef-valeur-"+i).innerHTML;
                document.getElementById("coef-valeur-"+i).innerHTML = th.formatMoyenne(element.valeur * coefficient) + '/' + 20*coefficient;
            }
        });
        // console.log("l'index trouvé est "+JSON.stringify(found));
        /*for(i = this.valeurs.length - 1; i >= 0; i--){
            var valeur = this.valeurs[i].valeur;
            if(document.getElementById("valeur-"+i)){
                document.getElementById("valeur-"+i).innerHTML = this.formatMoyenne(valeur) + '/20';
                var coefficient = document.getElementById("coef-valeur-"+i).innerHTML;
                document.getElementById("coef-valeur-"+i).innerHTML = this.formatMoyenne(valeur * coefficient) + '/' + 20*coefficient;
            }
            // console.log(" index "+i);
        }*/
    }
  }
};
</script>
