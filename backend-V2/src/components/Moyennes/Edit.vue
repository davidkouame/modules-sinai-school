<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="moyenne">
          <form v-on:submit="saveMoyenne">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Elève</label>
                      <!---->
                      <select v-model="moyenne.eleve_id" class="form-control" >
                      <option value="">Sélectionnez un élève</option>
                      <option :value="eleve.id" v-for="eleve in eleves">{{ eleve.name }} {{ eleve.surname }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matière</label>
                      <!---->
                      <select v-model="moyenne.matiere_id" class="form-control" >
                      <option value="">Sélectionnez une matière</option>
                      <option :value="matiere.id" v-for="matiere in matieres">{{ matiere.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coéfficient de la moyenne</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="moyenne.coefficient_matiere"
                        placeholder="Coefficient"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coéfficient de la section</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="moyenne.coefficient_section"
                        placeholder="Coefficient"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Valeur</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="moyenne.valeur"
                        placeholder="Valeur"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Rang</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="moyenne.rang"
                        placeholder="Rang"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Sections année scolaire</label>
                      <!---->
                      <select v-model="moyenne.section_annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une section année scolaire</option>
                      <option :value="sectionanneescolaire.id" v-for="sectionanneescolaire in sectionsanneescolaire">{{ sectionanneescolaire.libelle }} </option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Classe</label>
                      <!---->
                      <select v-model="moyenne.classe_id" class="form-control" >
                      <option value="">Sélectionnez une classe</option>
                      <<option :value="classe.id" v-for="classe in classes">{{ classe.libelle }} </option>
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
                      <select v-model="moyenne.annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une année scolaire</option>
                      <option :value="anneescolaire.id" v-for="anneescolaire in anneesscolaires">{{ anneescolaire.libelle }} </option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Type de moyenne</label>
                      <!---->
                      <select v-model="moyenne.type_moyenne_id" class="form-control" >
                      <option value="">Sélectionnez un type de moyenne</option>
                      <option :value="typesmoyenne.id" v-for="typesmoyenne in typesmoyenne">{{ typesmoyenne.libelle }} </option>
                      </select>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <input
                        class="form-control"
                        type="number"
                        v-model="moyenne.reference"
                        disabled
                      />
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Modifier</button>
                    </div> 
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>


export default {
  data() {
    return {
      title: "Modifier une moyenne",
      valueDisabled: false
    };
  },
  created() {
    // recuperation de l'moyenne
    this.$store.dispatch("getMoyenne", {
      moyenneId: this.$route.params.id
    });
    // recuperation des eleves
    this.$store.dispatch('getAllEleves', {payload: 0})
    // recuperation des matieres
    this.$store.dispatch('getAllMatieres', {payload: 0})
    // recuperation des classes
    this.$store.dispatch('getAllClasses', {payload: 0})
    // recuperation des classes
    this.$store.dispatch('getAllClasses', {payload: 0})
    // recuperation des sections
    this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0})
    // recuperation des années scolaires
    this.$store.dispatch('getAllAnneesScolaires', {payload: 0})
    // recuperation des types de moyennes
    this.$store.dispatch('getAllTypesMoyenne', {payload: 0})
  },
  methods:{
    saveMoyenne(){
      this.valueDisabled = true;
      let data = {
        eleve_id: this.moyenne.eleve_id,
        matiere_id: this.moyenne.matiere_id,
        coefficient_matiere: this.moyenne.coefficient_matiere,
        coefficient_section: this.moyenne.coefficient_section,
        classe_id: this.moyenne.classe_id,
        valeur: this.moyenne.valeur,
        rang: this.moyenne.rang,
        section_annee_scolaire_id: this.moyenne.section_annee_scolaire_id,
        annee_scolaire_id: this.moyenne.annee_scolaire_id,
        type_moyenne_id: this.moyenne.type_moyenne_id,
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "moyennes", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    moyenne() {
      return this.$store.getters.moyenne;
    },
    eleves(){
      return this.$store.getters.eleves
    },
    raisonsmoyennes(){
      return this.$store.getters.raisonsmoyennes
    }
  },
  watch:{
    moyenne(){
      this.heure_debut = this.moyenne.heure_debut_cours.replace(' ', 'T')+'.00000'
      this.heure_fin = this.moyenne.heure_fin_cours.replace(' ', 'T')+'.00000'
    },
    eleves(){
      return this.$store.getters.eleves
    },
    matieres(){
      return this.$store.getters.matieres
    },
    sectionsanneescolaire(){
      return this.$store.getters.sectionsanneescolaire
    },
    classes(){
      return this.$store.getters.classes
    },
    anneesscolaires(){
      return this.$store.getters.anneesscolaires
    },
    typesmoyenne(){
      return this.$store.getters.typesmoyenne
    }
  }
};
</script>
