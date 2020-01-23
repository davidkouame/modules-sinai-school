<template>
  <div class="container">
    <div>DetailNote {{ $route.params.id }}</div>
    {{ classesprofesseursmatieres }}
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
            <input type="text" class="form-control" v-bind:value="eleve.surname" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Matricule</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.matricule" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Date de naissance</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.datenaissance" disabled />
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
            <input type="text" class="form-control" v-bind:value="eleve.users.email" disabled />
          </div>
        </div>
      </fieldset>

      <!-- Information parent -->
      <fieldset v-if="eleve">
        <legend>Information du parent</legend>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.parent.name" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Prénoms</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.parent.surname" disabled />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Matricule</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" v-bind:value="eleve.parent.matricule" disabled />
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
            <input type="text" class="form-control" v-bind:value="eleve.parent.tel" disabled />
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

      <!-- Information notes -->
      <fieldset v-if="eleve">
        <legend>Information notes</legend>
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="input-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="searchkeys"
                  placeholder="Rechercher une note"
                  aria-label="Recipient's username"
                  aria-describedby="button-addon2"
                />
                <div class="input-group-append">
                  <button
                    class="btn btn-outline-secondary"
                    id="button-addon2"
                    v-on:click="searchNote"
                  >rechercher</button>
                </div>
              </div>
            </div>
            <div class="col">
              <a :href="'#/notes/add'" class="btn btn-primary">Ajouter une note</a>
            </div>
          </div>
          <br />
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
                    <td>{{ note.libelle }}</td>
                    <td>{{ note.created_at|formatDate }}</td>
                    <td>
                      <span v-if="note.typenote">{{ note.typenote.libelle }}</span>
                    </td>
                    <td>
                      <a :href="'#/notes/preview/'+note.id" class="btn btn-primary">Voir</a>
                      <a :href="'#/notes/update/'+note.id" class="btn btn-primary">Modifier</a>
                      <button
                        id="show-modal"
                        @click="showModalF(note.id, 'note')"
                        class="btn btn-danger"
                      >Supprimer</button>
                    </td>
                  </tr>
                </tbody>
              </table>

              <modal v-if="showModal" @close="showModal = false" v-bind:modelid="noteid" modelname="note"></modal>

              <paginate
                :page-count="pageCountNote"
                :click-handler="fetchNote"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
              ></paginate>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend>Information absences</legend>
        <div class="container">
          <div class="row">
            <div class="col">
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
                <div class="input-group-append">
                  <button
                    class="btn btn-outline-secondary"
                    id="button-addon2"
                    v-on:click="searchAbsenceEleve"
                  >rechercher</button>
                </div>
              </div>
            </div>
            <div class="col">
              <a :href="'#/absences-eleves/add'" class="btn btn-primary">Ajouter une absence</a>
            </div>
            <!--<div class="col">
              <a :href="'#/absences-eleves/add'" class="btn btn-primary">Ajouter une absence</a>
            </div>-->
          </div>
          <br />
          <div class="row">
            <div class="col-md-12">
              <table class="table">
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
                    <th scope="row">{{ index + 1}}</th>
                    <td>{{ absenceeleve.heure_debut_cours}}</td>
                    <td>{{ absenceeleve.heure_fin_cours}}</td>
                    <!-- <td>{{ noteeleve.note.created_at|formatDate }}</td> -->
                    <td v-if="absenceeleve.raisonabsence">{{ absenceeleve.raisonabsence.libelle }}</td>
                    <td v-else="absenceeleve.raisonabsence"></td>
                    <td>
                      <!--<a :href="'#/absence-eleve/'+absenceeleve.id" class="btn btn-primary">detail</a>-->

                      <a
                        :href="'#/absences-eleves/preview/'+absenceeleve.id"
                        class="btn btn-primary"
                      >Voir</a>
                      <a
                        :href="'#/absences-eleves/update/'+absenceeleve.id"
                        class="btn btn-primary"
                      >Modifier</a>
                      <button
                        id="show-modal"
                        @click="showModalF(absenceeleve.id, 'absence')"
                        class="btn btn-danger"
                      >Supprimer</button>
                    </td>
                  </tr>
                </tbody>
              </table>

              <!--<modal
                v-if="showModal"
                @close="showModal = false"
                v-bind:modelid="absenceid"
                modelname="absence"
              ></modal>-->

              <paginate
                :page-count="pageCount"
                :click-handler="fetchAbsence"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
              ></paginate>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
    <a :href="'#/eleves'" class="btn btn-primary">retour</a>
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
      modelname: null
    };
  },
  created() {
    this.eleveId = this.$route.params.id;
    this.$store.dispatch("eleve", this.eleveId);
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
        this.$store.dispatch("allnotes", {
          payload: pageNum,
          search: [{ key: "libelle", value: search }]
        });
      } else {
        this.$store.dispatch("allnotes", { payload: pageNum, search: [{key:'professeur_id', value:1}] });
      }
    },
    searchNote() {
      this.fetch(null, this.searchkeys);
    },
    showModalF (noteId = null, modelname = null) {
      this.showModal = true
      this.noteid = noteId
      this.modelname = modelname
    },
    trimSearch(searchs = null){
      let params = [];
      for (var key in searchs) {
        if(searchs[key].value){
          params.push({'key': searchs[key].key, 'value': searchs[key].value});
        }
      }
      return params;
    }
  },
  computed: {
    notes() {
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
    pageCountNote() {
      return this.$store.getters.pageCountNote;
    },
    classesprofesseursmatieres(){
      return this.$store.getters.classesprofesseursmatieres
    }
  }
};
</script>
