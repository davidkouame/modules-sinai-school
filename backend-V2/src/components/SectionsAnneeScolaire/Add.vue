<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-on:submit="saveAnneeScolaire">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="sectionanneescolaire.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de début</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="sectionanneescolaire.start"
                        placeholder="Date de début"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de fin</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="sectionanneescolaire.end"
                        placeholder="Date de fin"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de validation</label>
                      <!---->
                      <input
                        class="form-control"
                        type="date"
                        v-model="sectionanneescolaire.validated_at"
                        placeholder="Date de validation"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Année scolaire</label>
                      <!---->
                      <select v-model="sectionanneescolaire.annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une année scolaire</option>
                      <option :value="anneescolaire.id" v-for="anneescolaire in anneesscolaires">{{ anneescolaire.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coefficient</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="sectionanneescolaire.coefficient"
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
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Envoyer <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
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
      title: "Ajouter une section année scolaire",
      sectionanneescolaire: {"libelle": "", "start": "", "end": "", "validated_at": "", "annee_scolaire_id": "", "coefficient": ""},
      valueDisabled: false
    };
  },
  created() {
    // recuperation de toutes les années scolaires
    this.$store.dispatch('getAllAnneesScolaires', {payload: 0})
  },
  methods:{
    saveAnneeScolaire(){
      this.valueDisabled = true;
      let data = {
        libelle: this.sectionanneescolaire.libelle,
        start: this.sectionanneescolaire.start,
        end: this.sectionanneescolaire.end,
        validated_at: this.sectionanneescolaire.validated_at,
        annee_scolaire_id: this.sectionanneescolaire.annee_scolaire_id,
        coefficient: this.sectionanneescolaire.coefficient,
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "sectionsanneescolaire", "data": data})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
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
    anneesscolaires(){
      return this.$store.getters.anneesscolaires
    }
  }
};
</script>
