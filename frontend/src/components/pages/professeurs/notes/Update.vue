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
            <a href="#/notes">Notes</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Modifier une note</li>
        </ol>
      </nav>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Modifier une note</h4>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Libelle</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="libelle" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Date de note effectué</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" v-model="datenoteeffectue" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Types notes</label>
                  <div class="col-sm-10">
                    <select v-model="typenote" class="form-control">
                      <option value>Sélectionner un type de note</option>
                      <option
                        :value="typenote.id"
                        v-for="typenote in typesnotes"
                      >{{ typenote.libelle }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Classes</label>
                  <div class="col-sm-10">
                    <!--<select
                      v-model="classe"
                      class="form-control"
                      multiple="true"
                      v-bind:class="{ 'fix-height': multiple === 'true' }"
                    >
                      <option value>Sélectionner une ou plusieurs classes</option>
                      <option
                        :value="classe.classe.id"
                        v-for="classe in classes"
                      >{{ classe.classe.libelle }}</option>
                    </select>-->
                    <select
                      v-model="classe"
                      class="form-control"                    >
                      <option value>Sélectionner une ou plusieurs classes</option>
                      <option
                        :value="classe.classe.id"
                        v-for="classe in classes"
                      >{{ classe.classe.libelle }}</option>
                    </select>
                  </div>
                </div>

                <!-- Matiere -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matières</label>
                  <div class="col-sm-10">
                    <select class="form-control" v-model="matiere_id">
                      <option value>Sélectionner une matière</option>
                      <option v-for="ele in matieres" :value="ele.id">{{ ele.libelle }}</option>
                    </select>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Coefficient</label>
                  <div class="col-sm-10">
                    <input v-model="coefficient" type="number" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <textarea v-model="description" class="form-control"></textarea>
                  </div>
                </div>
                <a v-on:click="createNote()" class="btn btn-primary float-right">Enregistrer</a>
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
  name: "UpdateNote",
  data() {
    return {
      typenote: null,
      description: null,
      libelle: null,
      datenoteeffectue: null,
      matiere: null,
      classe: null,
      coefficient: null,
      multiple: true,
      matiere_id: null
    };
  },
  created() {
    this.$store.dispatch("eleves");
    this.$store.dispatch("typesnotes");
    this.$store.dispatch("matieresall");
    this.$store.dispatch(
      "classesByProfesseur",
      this.$cookies.get("professeurId")
    );
    this.$store.dispatch('classes', [{'key': 'professeur_id', 
    'value': this.$cookies.get('professeurId')}]);
    this.$store.dispatch("note", this.$route.params.id);
  },
  methods: {
    createNote() {
      const data = {};
      data["libelle"] = this.libelle;
      data["datenoteeffectue"] = this.datenoteeffectue;
      data["typenote_id"] = this.typenote;
      data["classe_id"] = this.classe;
      data["coefficient"] = this.coefficient;
      data["id"] = this.$route.params.id;
      data["description"] = this.description;
      data["matiere_id"] = this.matiere_id;
      data["professeur_id"] = this.$cookies.get("professeurId");

      let store = this.$store;
      store
        .dispatch("saveNote", data)
        .then(response => {
          // store.dispatch("raisonsabsences", response.data.data);
          alert("La modification de la note a été un succèss");
          // this.$router.push('/notes')
          this.$router.go(-1);
        })
        .catch(error => {
          console.log(error);
           alert("echec lors de l'enregistrement");
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    eleves() {
      return this.$store.getters.eleves;
    },
    typesnotes() {
      return this.$store.getters.typesnotes;
    },
    matieres() {
      return this.$store.getters.matieres;
    },
    classesByProfesseur() {
      return this.$store.getters.classesByProfesseur;
    },
    classeByProfesseur() {
      return this.$store.getters.classeByProfesseur;
    },
    note() {
      return this.$store.getters.note;
    },
    classes () {
       console.log("@@@@@@@@@@@@@@@@@@@@@");
       console.log(JSON.stringify(this.$store.getters.classes));
      return this.$store.getters.classes;
    }
  },
  watch: {
    note: function() {
      if (this.note) {
        this.libelle = this.note.libelle;
        this.typenote = this.note.typenote.id;
        this.datenoteeffectue = this.note.datenoteeffectue.split(" ")[0]; // this.note.datenoteeffectue;
        this.coefficient = this.note.coefficient;
        this.description = this.note.description;
        this.matiere_id = this.note.matiere_id;
        // this.classe = [1,2];
        this.classe = this.note.classe_id;
      }
    }
  }
};
</script>
