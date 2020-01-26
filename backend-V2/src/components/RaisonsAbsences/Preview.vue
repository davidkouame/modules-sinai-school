<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="raisonabsence">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="raisonabsence.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/raisonsabsences" class="btn btn-danger float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail Raison absence",
    };
  },
  created() {
    this.$store.dispatch("getRaisonAbsence", {
      raisonabsenceId: this.$route.params.id
    });
  },
  computed: {
    raisonabsence() {
      return this.$store.getters.raisonabsence;
    }
  }
};
</script>
