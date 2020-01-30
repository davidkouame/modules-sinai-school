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
          <li class="breadcrumb-item active" aria-current="page">Détailler une note</li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Titre de la page -->
            <div class="card-header">
              <h4 class="card-title">Détailler une note</h4>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Libelle</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="libelle" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Date de note effectué</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" v-model="datenoteeffectue" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Types notes</label>
                  <div class="col-sm-10">
                    <input v-bind:value="note.typenote.libelle" type="text" class="form-control" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Classes</label>
                  <div class="col-sm-10">
                    <input v-bind:value="note.classe.libelle" type="text" class="form-control" disabled/>
                  </div>
                </div>

                <!-- Matiere -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Matières</label>
                  <div class="col-sm-10">
                    <input v-bind:value="note.matiere.libelle" type="text" class="form-control" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Coefficient</label>
                  <div class="col-sm-10">
                    <input v-model="coefficient" type="number" class="form-control" disabled/>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <textarea v-model="description" class="form-control" disabled></textarea>
                  </div>
                </div>
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
  name: "PreviewNote",
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
      matiere_id: null
    };
  },
  created() {
    this.$store.dispatch("eleves");
    this.$store.dispatch("typesnotes");
    this.$store.dispatch("matieres");
    this.$store.dispatch(
      "classesByProfesseur",
      this.$cookies.get("professeurId")
    );
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
    }
  }
};
</script>
