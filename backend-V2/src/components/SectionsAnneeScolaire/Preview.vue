<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="sectionanneescolaire">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="sectionanneescolaire.libelle"
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
                        v-bind:value="sectionanneescolaire.start|formatDate"
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
                        v-bind:value="sectionanneescolaire.end|formatDate"
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
                        v-model="sectionanneescolaire.validated_at"
                        disabled
                      />
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
                        type="text"
                        v-model="sectionanneescolaire.coefficient"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="sectionanneescolaire.anneescolaire.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
              <div class="float-right">
                <a href="#/sections-annee-scolaire" class="btn btn-danger">Retour</a>
                &nbsp;
                <a @click="validateSection" class="btn btn-primary btn-add" v-if="!sectionanneescolaire.validated_at">Valider1 la section</a>
                <a href="javascript:void(0)" class="btn btn-primary float-right btn-add" v-if="sectionanneescolaire.validated_at" disabled>Valider2 la section</a>

                <!--<a @click="generateMoyenne" class="btn btn-primary float-right" style="background: #EE2D20;color: #fff;opacity: 1;">Générer la moyenne</a>-->
                
                
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
      title: "Détail section année scolaire",
    };
  },
  created() {
    this.$store.dispatch("getSectionAnneeScolaire", {
      sectionAnneeScolaireId: this.$route.params.id
    });
  },
  computed: {
    sectionanneescolaire() {
      return this.$store.getters.sectionanneescolaire;
    }
  },
  methods:{
    generateMoyenne(){
      alert("la moyenne a été généré avec succes ")
    },
    validateSection(){
      /*var currentDate = new Date();
      console.log(currentDate);
      var currentDateWithFormat = new Date().toJSON().replace('T',' ').replace('Z', ' ');
      currentDateWithFormat.replace('Z', ' ');
      // console.log(currentDateWithFormat);
      let data = {
        validated_at: currentDateWithFormat // new Date().toJSON(),
      };*/
      let store = this.$store;
      store
        .dispatch("validateModel", {"url": "sectionsanneescolaire", "data": {}, "id": this.$route.params.id})
        .then(response => {
          alert("La section a été validé avec succès !")
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
