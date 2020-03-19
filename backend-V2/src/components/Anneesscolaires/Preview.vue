<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="anneescolaire">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="anneescolaire.libelle"
                        disabled
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
                        type="text"
                        v-model="anneescolaire.start"
                        disabled
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
                        type="text"
                        v-model="anneescolaire.end"
                        disabled
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
                        type="text"
                        v-model="anneescolaire.validated_at"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Type d'année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="anneescolaire.typeanneescolaire.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <a href="#/annees-scolaires" class="btn btn-danger">Retour</a>
                  &nbsp;
                  <a @click="validateAnneeScolaire" class="btn btn-primary" v-if="!anneescolaire.validated_at">Valider l'année scolaire</a>
                  <a href="javascript:void(0)" class="btn btn-primary" disabled v-else>Valider l'année scolaire</a>
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
      title: "Détail année scolaire",
    };
  },
  created() {
    this.$store.dispatch("getAnneeScolaire", {
      anneeScolaireId: this.$route.params.id
    });
  },
  computed: {
    anneescolaire() {
      return this.$store.getters.anneescolaire;
    }
  },
  methods:{
    validateAnneeScolaire(){
      /*var currentDate = new Date();
      var currentDateWithFormat = new Date().toJSON().replace('T',' ').replace('Z', ' ');
      currentDateWithFormat.replace('Z', ' ');
      let data = {
        validated_at: currentDateWithFormat // new Date().toJSON(),
      };*/
      let store = this.$store;
      store
        .dispatch("validateModel", {"url": "anneesscolaires", "data": {}, "id": this.$route.params.id})
        .then(response => {
          alert("L'année scolaire a été validé avec succès !")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("Echec lors de la validation")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>
