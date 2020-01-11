<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12 card-body-body">
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
                        >Notes</a>
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
                        >Moyennes matières</a>
                      </li>
                      <li class="nav-item">
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
                        >Moyennes section</a>
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link"
                          :class="{active:selected == 4}"
                          @click="selected = 4"
                          id="classes"
                          data-toggle="tab"
                          href="javascript:void(0)"
                          role="tab"
                          aria-controls="profile"
                          aria-selected="false"
                        >Moyenne annuelle</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-content" id="myTabContent">
                      <br />
                      <!-- Tab Notes -->
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
                                  <th scope="col">Libellé</th>
                                  <th scope="col">Note</th>
                                  <th scope="col">Coefficient</th>
                                  <th scope="col">Coeff x Val</th>
                                  <th scope="col">Date</th>
                                  <th scope="col">Type de note</th>
                                  <th scope="col">Matière</th>
                                  <th scope="col">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="notes" v-for="(note, index) in notes">
                                  <th scope="row">{{ index + 1}}</th>
                                  <td>{{ note.note.libelle }}</td>
                                  <td>{{ note.noteeleve && formatValeur(note.noteeleve.valeur) ? formatValeur(note.noteeleve.valeur)+'/20': '--' }}</td>
                                  <td>{{ note.note.coefficient }}</td>
                                  <td>{{ note.noteeleve && formatValeur(note.noteeleve.valeur*note.note.coefficient) ? formatValeur(note.noteeleve.valeur*note.note.coefficient)+'/'+note.note.coefficient*20 : '--'}}</td>
                                  <td>{{ note.note.created_at|formatDate }}</td>
                                  <td>{{ note.typenote.libelle }}</td>
                                  <td>{{ note.matiere.libelle }}</td>
                                  <td>
                                    <a id="show-modal" @click="showModalF(note.note.id)" type="button" class="btn btn-icon btn-success btn-sm">
                                      <!----><i class="fa fa-edit"></i><!---->
                                    </a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <modal
                              v-if="showModal"
                              @close="showModal = false"
                              v-bind:modelid="noteEleveId"
                              modelname="noteleve"
                              nameUrl="noteseleves"
                              modaltype="addValue"
                              v-bind:eleveId="classeeleve.eleve_id"
                            ></modal>

                            <div class="row" v-if="pageCount > 1">
                              <div class="col-md-4" style="color: #98a7a8;font-size: 13px;">
                                Enregistrements affichés : {{ currentPage }}-{{ countPage }} sur {{ totalElement }}
                              </div>
                              <div class="col-md-8">
                                <div class="float-right pagi">
                                  <paginate
                                    :page-count="pageCount"
                                    :click-handler="dispatchNotes"
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
                      <!-- Tab Moyennes de matières -->
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
                                  <th scope="col">Moyenne</th>
                                  <th scope="col">Coef.</th>
                                  <th scope="col">Coef. * Moy.</th>
                                  <th scope="col">Rang</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="moyennesmatieres" v-for="(moyenne, index) in moyennesmatieres">
                                  <th scope="row">{{ index + 1}}</th>
                                  <td>{{ formatMoyenne(moyenne.valeur) }} / 20</td>
                                  <td>{{ moyenne.coefficient_matiere }}</td>
                                  <td>
                                       {{ formatMoyenne(moyenne.valeur * moyenne.coefficient_matiere) }} /
                                       {{ moyenne.coefficient_matiere * 20 }}</td>
                                  <td>{{ moyenne.rang ? moyenne.rang : '--'  }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                      </div>
                      <!-- Tab Moyennes de sections -->
                      <div
                        class="tab-pane fade"
                        :class="{show:selected == 3,active:selected == 3}"
                        id="profile"
                        role="tabpanel"
                        aria-labelledby="classes">
                        <div class="col-12">
                           <table class="table table-d">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Libellé</th>
                                  <th scope="col">Moyenne</th>
                                  <th scope="col">Coef.</th>
                                  <th scope="col">Coef. * Moy.</th>
                                  <th scope="col">Rang</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="moyennessections" v-for="(moyenne, index) in moyennessections">
                                  <th scope="row">{{ index + 1}}</th>
                                  <th>{{ moyenne.sectionanneescolaire.libelle }}</th>
                                  <td>{{ formatMoyenne(moyenne.valeur) }} / 20</td>
                                  <td>{{ moyenne.coefficient_section }}</td>
                                  <td>
                                       {{ formatMoyenne(moyenne.valeur * moyenne.coefficient_section) }} /
                                       {{ moyenne.coefficient_section * 20 }}</td>
                                  <td>{{ moyenne.rang ? moyenne.rang : '--'  }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                      </div>
                       <!-- Tab Moyenne annuelle -->
                      <div
                        class="tab-pane fade"
                        :class="{show:selected == 4,active:selected == 4}"
                        id="profile"
                        role="tabpanel"
                        aria-labelledby="classes">
                        <div class="col-12">
                           <table class="table table-d">
                              <thead>
                                <tr>
                                  <th scope="col">Moyenne annuelle</th>
                                  <th scope="col">Rang</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="moyenneannuelle">
                                  <td>{{ moyenneannuelle.valeur }} / 20</td>
                                  <td>{{ moyenneannuelle.rang ? moyenneannuelle.rang : '--'  }}</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                  </div>
          </div>
        </div>
      </div>
  </card>
</template>

<script>

import moment from 'moment'

export default {
  data() {
    return {
      title: "Information élève",
      selected: 1,
      noteEleveId: null,
      showModal: false
    };
  },
  created() {
    // recuperation de la classe-eleve
    this.$store.dispatch('getClasseEleve', {classeEleveId: this.$route.params.id})
  },
  methods:{
    dispatchNotes(pageNum, search = null){
      pageNum = pageNum == null ? 1 : pageNum
      let params = [{key: 'search', value: search},
       {key: 'classe_id', value: this.classeeleve.classe_id},
       {key: 'eleve_id', value: this.classeeleve.eleve_id}
       ];
      this.$store.dispatch('getNotesWithValues', {payload: pageNum, search: this.trimSearch(params)})
    },
    dispatchMoyennesMatieres(){
      let params = [{key: 'classe_id', value: this.classeeleve.classe_id},
       {key: 'eleve_id', value: this.classeeleve.eleve_id},
       {key: 'type_moyenne_id', value: 2}
       ];
      this.$store.dispatch('getMoyennesMatieres', {page: 0, search: this.trimSearch(params)})
    },
    dispatchMoyennesSections(){
      let params = [{key: 'classe_id', value: this.classeeleve.classe_id},
       {key: 'eleve_id', value: this.classeeleve.eleve_id},
       {key: 'type_moyenne_id', value: 3}
       ];
      this.$store.dispatch('getMoyennesSections', {page: 0, search: this.trimSearch(params)})
    },
    dispatchMoyenneAnnuelle(){
      let params = [{key: 'classe_id', value: this.classeeleve.classe_id},
       {key: 'eleve_id', value: this.classeeleve.eleve_id},
       {key: 'type_moyenne_id', value: 1}
       ];
      this.$store.dispatch('getMoyenneAnnuelle', {page: 0, search: this.trimSearch(params)})
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
    },
    trimSearch(searchs = null){
      let params = [];
      for (var key in searchs) {
        // console.log("type of "+typeof searchs[key].value)
        if(searchs[key].value){
          params.push({'key': searchs[key].key, 'value': searchs[key].value});
        }
      }
      return params;
    },
    showModalF(noteEleveId = null) {
      this.showModal = true;
      this.noteEleveId = noteEleveId;
    },
    formatMoyenne(moy){
        if(moy){
          let moyennes = moy.toString().split(".");
          let partieEntiere = null;
          let partieDecimal = null;
          if(moyennes[0].toString().length==1){
            partieEntiere = '0'+moyennes[0];
          }else{
            partieEntiere = moyennes[0];
          }
          if(moyennes[1]){
            if(moyennes[1].length == 1){
              partieDecimal = moyennes[1]+"0";
            }else if(moyennes[1].length > 1){
              partieDecimal = moyennes[1].substr(0, 2);
            }
          }else{
            partieDecimal = "00";
          }
          return partieEntiere+"."+partieDecimal;
        }else{
          return "--"
        }
    }
  },
  computed:{
    notes() {
      return this.$store.getters.notes;
    },
    pageCount() {
      return this.$store.getters.pageCount;
    },
    classeeleve(){
      return this.$store.getters.classeeleve;
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
    showEmptySentenceNotes(){
      return  this.notEmptyObject(this.notes) == 0
    },
    moyennesmatieres(){
      return this.$store.getters.moyennesmatieres;
    },
    moyennessections(){
      return this.$store.getters.moyennessections;
    },
    moyenneannuelle(){
      console.log("recuperation de la moyenne annuelle "+JSON.stringify(this.$store.getters.moyenneannuelle))
      return this.$store.getters.moyenneannuelle;
    }
  },
  watch:{
    classeeleve(){
      // console.log("classe eleve "+JSON.stringify(this.classeeleve))
      // recuperation des notes
      this.dispatchNotes(1)
      // recuperation des moyennes des matieres
      this.dispatchMoyennesMatieres()
      // recuperation des moyennes des sections
      this.dispatchMoyennesSections()
      // recuperation de la moyenne annuelle
      this.dispatchMoyenneAnnuelle()
    }
  }
};
</script>
