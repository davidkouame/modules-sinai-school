<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Détail d'absence</h4>
            </div>
            <div class="card-body">
              <form v-if="absenceeleve">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de début</label>
                      <!---->
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="First Name"
                        class="form-control"
                        type="text"
                        v-model="absenceeleve.heure_debut_cours"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de fin</label>
                      <!---->
                      <input
                        aria-describedby="addon-right addon-left"
                        placeholder="Last Name"
                        class="form-control"
                        type="text"
                        v-model="absenceeleve.heure_fin_cours"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Raison d'absence</label>
                      <!---->
                      <input
                        v-if="absenceeleve.raisonabsence"
                        aria-describedby="addon-right addon-left"
                        placeholder="Home Address"
                        class="form-control"
                        type="text"
                        v-model="absenceeleve.raisonabsence.libelle"
                        disabled
                      />

                      <input
                        v-if="!absenceeleve.raisonabsence"
                        aria-describedby="addon-right addon-left"
                        placeholder="Raison d'absence"
                        class="form-control"
                        type="text"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea
                        name
                        id
                        cols="30"
                        rows="3"
                        aria-describedby="addon-right addon-left"
                        class="form-control"
                        disabled
                      >
                  {{ absenceeleve.commentaire }}
                  </textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a @click="$router.go(-1)" class="btn btn-danger float-right">Retour</a>
              </form>
            </div>
            <!---->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DetailAbsenceEleve",
  created() {
    this.$store.dispatch("absenceeleve", {
      absenceEleveId: this.$route.params.id
    });
  },
  computed: {
    absenceeleve() {
      return this.$store.getters.absenceeleve;
    }
  }
};
</script>
