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
            <a href="#/moyennes">Moyennes</a>
          </li>
            <li class="breadcrumb-item active" aria-current="page">Détail moyenne</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Détail moyenne</h4>
            </div>
            <div class="card-body">
              <form v-if="moyenne">
                <!--<div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matricule</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="moyenne.eleve.matricule" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nom</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="moyenne.eleve.name" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Prénom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="moyenne.eleve.surname" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Moyenne</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-bind:value="formatMoyenne(moyenne.valeur)" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Coefficient</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="moyenne.coefficient_matiere" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Coefficient * Moy</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-bind:value="formatMoyenne(moyenne.coefficient_matiere*moyenne.valeur, 4)" disabled/>
                    </div>
                </div>-->

                <table class="table table-hover table-striped">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Libellé</th>
                          <th scope="col">Date</th>
                          <th scope="col">Type de note</th>
                          <th scope="col">Valeur</th>
                          <th scope="col">Coef.</th>
                          <th scope="col">Coef. * Valeur</th>
                          <th scope="col" v-show="seeAction">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="countNotes" v-for="(note, index) in notes">
                          <th scope="row">{{ index + 1}}</th>
                          <td>{{ note.libelle }}</td>
                          <td>{{ note.created_at|formatDate }}</td>
                          <td>{{ note.type_note_libelle }}</td>
                          <!--<td v-bind:id="'note-'+note.id">{{ getValeur() }}</td>-->
                          <td> {{ formatValeur(note.valeur) ? formatValeur(note.valeur)+'/20': '--' }} </td>
                          <td>{{ note.coefficient }}</td>
                          <!--<td>{{ formatMoyenne(note.coefficient*getValeur(index)) }} / {{ note.coefficient * 20 }}</td>-->
                          <td>{{ formatValeur(note.valeur*note.coefficient) ? formatValeur(note.valeur*note.coefficient)+'/'+note.coefficient*20 : '--'}}</td>
                          <td>
                            <div class="row">
                              <a :href="'/#/notes/preview/'+note.note_eleve_id" class="col">
                                <i class="fa fa-eye fa-lg"></i>
                              </a>
                              <!--<a :href="'/#/notes/update/'+note.id" class="col">
                                <i class="fa fa-pencil fa-lg"></i>
                              </a>-->
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

                <!--<a @click="$router.go(-1)" class="btn btn-danger float-right" style="border-right-width: 2px;margin-right: 10px;">Annuler</a>-->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PreviewMoyenne",
  data() {
    return {
      typenote: null,
      description: null,
      libelle: null,
      datenoteeffectue: null,
      matiere: null,
      classe: [],
      coefficient: null,
      multiple: true,
      matiere_id: null,
      countNotes: false,
      eleveIdModal: null,
      showModal: false,
      modelname: null,
      seeAction: true
    };
  },
  created() {
    this.$store.dispatch("moyenne", this.$route.params.id);
    // this.fetchNote();
  },
  methods: {
    fetchNote(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      this.$store.dispatch("allnotesandvaleurV2", {
          payload: pageNum,
          search: [{ key: "eleve_id", value: localStorage.getItem('eleveId') },
                    { key: "matiere_id", value: this.moyenne.matiere_id }]
        });
    },
    formatMoyenne(moy, coef = 1){
        if(moy.toString().length==1){
            return '0'+moy+'/'+coef*20;
        }else{
            return moy+'/'+coef*20;
        }
    },
    formatMoyenne2(moy){
        if(moy.toString().length==1){
            return '0'+moy;
        }else{
            return moy;
        }
    },
    showModalF(noteId = null, modelname = null, eleveId = null) {
      this.showModal = true;
      this.noteid = noteId;
      this.modelname = modelname;
      this.eleveIdModal = this.moyenne.eleve.id;
      // console.log(">>>>>>> "+noteId);
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
    }
  },
  computed: {
    notes() {
      let notes = this.$store.getters.notes;
      console.log("tentatives de recuperations des notes ");
      if(notes){
        console.log("recuperation des notes");
        this.countNotes = this.$store.getters.notes.length;
        this.countNotes = this.countNotes > 0;
        console.log("notes "+JSON.stringify(this.$store.getters.notes));
      }
      return this.$store.getters.notes;
    },
    moyenne(){
        return this.$store.getters.moyenne;
    }
  },
  watch: {
    note: function() {
      // console.log("nous avons changé la valeur de note "+JSON.stringify(this.note));
      if (this.note) {
        this.libelle = this.note.libelle;
        this.typenote = this.note.typenote.id;
        this.datenoteeffectue = this.note.datenoteeffectue.split(" ")[0]; // this.note.datenoteeffectue;
        this.coefficient = this.note.coefficient;
        this.description = this.note.description;
        this.matiere_id = this.note.matiere_id;
        // this.classe = [1,2];
        // console.log(this.note.classe_id.split(','));
        this.classe = this.note.classe_id;
        this.seeAction = this.note.rapport_validation_id != null ||
        this.note.rapport_validation_id != 0 ? false : true;
        // console.log("la validation est "+this.note.rapport_validation_id)
      }
    },
    moyenne(){
        this.fetchNote();
    }
  }
};
</script>
