<template>
  <card class="card" :title="title">
      <div class="row">
        <div v-if="error" class="col-md-12">
          <message-error v-bind:error="error"></message-error>
        </div>
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
            <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary btn-add" :disabled="valueDisabled">Modifier <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
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
      title: "Modifier une classe matière",
      valueDisabled: false
    };
  },
  created() {
    // recuperation de la classe professeur matiere
    this.$store.dispatch("getClasseProfesseurMatiere", {
      classeProfesseurMatiereId: this.$route.params.id
    });
    // recuperation de tous les professeurs
    this.$store.dispatch('getAllProfesseurs', {payload: 0, search : [{key: "school_id", value: this.$cookies.get('ecoleId')}]})
    // recuperation de toutes les matieres
    this.$store.dispatch('getAllMatieres', {payload: 0})
  },
  methods:{
    saveMatiere(){
      this.error = null;
      this.valueDisabled = true;
      let data = {
        matiere_id: this.classeprofesseurmatiere.matiere_id,
        professeur_id: this.classeprofesseurmatiere.professeur_id,
        coefficient: this.classeprofesseurmatiere.coefficient,
        annee_scolaire_id: this.classeprofesseurmatiere.classe.annee_scolaire_id,
        school_id: this.$cookies.get('ecoleId')
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "classesprofesseursmatieres", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          this.error = error;
          this.errored = true;
          this.valueDisabled = false;
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
