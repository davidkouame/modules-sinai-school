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
          <li class="breadcrumb-item active" aria-current="page">Détailler une moyenne</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Détailler une moyenne</h4>
            </div>
            <div class="card-body">
              <form v-if="moyenne">
                <div class="form-group row">
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
                </div>

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
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="countNotes" v-for="(note, index) in notes">
                          <th scope="row">{{ index + 1}}</th>
                          <td><a :href="'/#/notes/preview/'+note.id" >{{ note.libelle }}</a></td>
                          <td>{{ note.created_at|formatDate }}</td>
                          <td>
                            <span v-if="note.typenote">{{ note.typenote.libelle }}</span>
                          </td>
                          <!--<td v-bind:id="'note-'+note.id">{{ getValeur() }}</td>-->
                          <td v-bind:id="'valeur-'+note.id"></td>
                          <td>{{ note.coefficient }}</td>
                          <!--<td>{{ formatMoyenne(note.coefficient*getValeur(index)) }} / {{ note.coefficient * 20 }}</td>-->
                          <td v-bind:id="'coef-valeur-'+note.id">{{ note.coefficient }}</td>
                          <td>
                            <div class="row">
                              <!--<a :href="'/#/notes/preview/'+note.id" class="col">
                                <i class="fa fa-eye fa-lg"></i>
                              </a>-->
                              <!--<a :href="'/#/notes/update/'+note.id" class="col">
                                <i class="fa fa-pencil fa-lg"></i>
                              </a>-->
                                <a
                                v-if="!note.rapport_validation_id"
                                id="show-modal"
                                @click="showModalF(note.id, 'note')"
                                :class="note.id"
                                class="col "
                                style="cursor:pointer;color:#42d0ed"
                              >
                                <i class="fa fa-pencil fa-lg"></i>
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

                <a @click="$router.go(-1)" class="btn btn-danger float-right" style="border-right-width: 2px;margin-right: 10px;">Annuler</a>
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
    };
  },
  created() {
    this.$store.dispatch("moyenne", this.$route.params.id);
    // this.fetchNote();
  },
  methods: {
    fetchNote(pageNum, search = null) {
      pageNum = pageNum == null ? 1 : pageNum;
      if (search) {
        this.$store.dispatch("allnotesandvaleur", {
          payload: pageNum,
          search: [{ key: "libelle", value: search },
                  { key: "professeur_id", value: localStorage.getItem("professeurId") },
                  { key: "eleve_id", value: this.moyenne.eleve.id }]
        });
      } else {
        this.$store.dispatch("allnotesandvaleur", {
          payload: pageNum,
          search: [{ key: "professeur_id", value: localStorage.getItem("professeurId") },
                  { key: "eleve_id", value: this.moyenne.eleve.id }]
        });
      }
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
      console.log(">>>>>>> "+noteId);
    },
  },
  computed: {
    notes() {
      this.countNotes = this.$store.getters.notes.length;
      this.countNotes = this.countNotes > 0;
      return this.$store.getters.notes;
    },
    moyenne(){
        return this.$store.getters.moyenne;
    },
    valeurs(){
        return this.$store.getters.valeurs;
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
      }
    },
    moyenne(){
        this.fetchNote();
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
                document.getElementById("valeur-"+i).innerHTML = th.formatMoyenne2(element.valeur) + '/20';
                var coefficient = document.getElementById("coef-valeur-"+i).innerHTML;
                document.getElementById("coef-valeur-"+i).innerHTML = th.formatMoyenne2(element.valeur * coefficient) + '/' + 20*coefficient;
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
