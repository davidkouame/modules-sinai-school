<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="classeprofesseurmatiere">
          <form v-on:submit="saveMatiere">
            <div class="row">
              <div class="col-md-6" v-if="matieres">
                <div class="form-group">
                  <label class="control-label">Matières</label>
                  <!---->
                  <select v-model="classeprofesseurmatiere.matiere_id" class="form-control" >
                    <option value="">Sélectionnez une matière</option>
                    <option :value="matiere.id" v-for="matiere in matieres">{{ matiere.libelle }}</option>
                  </select>
                  <!---->
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Professeur</label>
                  <!---->
                  <select v-model="classeprofesseurmatiere.professeur_id" class="form-control" >
                  <option value="">Sélectionnez un professeur</option>
                  <option :value="professeur.id" v-for="professeur in professeurs">{{ professeur.nom +' '+ professeur.prenom}}</option>
                  </select>
                  <!---->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Coefficient</label>
                  <!---->
                  <input
                    class="form-control"
                    type="number"
                    v-model="classeprofesseurmatiere.coefficient"
                    placeholder="Coefficient"
                  />
                  <!---->
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
            <button type="submit" class="btn btn-primary">Modifier</button>
          </form>
        </div>
      </div>
  </card>
</template>

<script>

export default {
  data() {
    return {
      title: "Classe matière professeur"
    };
  },
  created() {
    // recuperation de la classe professeur matiere
    this.$store.dispatch("getClasseProfesseurMatiere", {
      classeProfesseurMatiereId: this.$route.params.id
    });
    // recuperation de tous les professeurs
    this.$store.dispatch('getAllProfesseurs', {payload: 0})
    // recuperation de toutes les matieres
    this.$store.dispatch('getAllMatieres', {payload: 0})
  },
  methods:{
    saveMatiere(){
      let data = {
        matiere_id: this.classeprofesseurmatiere.matiere_id,
        professeur_id: this.classeprofesseurmatiere.professeur_id,
        coefficient: this.classeprofesseurmatiere.coefficient,
        annee_scolaire_id: this.classeprofesseurmatiere.classe.annee_scolaire_id
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "classesprofesseursmatieres", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    matieres(){
      return this.$store.getters.matieres
    },
    professeurs(){
      return this.$store.getters.professeurs
    },
    classeprofesseurmatiere(){
      // console.log("log ==>"+JSON.stringify(this.$store.getters.classeprofesseurmatiere))
      return this.$store.getters.classeprofesseurmatiere
    },
  }
};
</script>
