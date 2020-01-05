<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="absence">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Elève</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        :value="absence.eleve.name"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Raison d'absence</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text" :value="absence.raisonabsence.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Heure de début</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        :value="absence.heure_debut_cours"
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
                        class="form-control"
                        type="text"
                        :value="absence.heure_fin_cours"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control"  disabled>{{ absence.commentaire }}</textarea>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Section année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        :value="absence.heure_fin_cours"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/absences" class="btn btn-danger float-right" style="background: #EE2D20;color: #fff;opacity: 1;">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Absence",
    };
  },
  created() {
    this.$store.dispatch("getAbsence", {
      absenceId: this.$route.params.id
    });
  },
  computed: {
    absence() {
      return this.$store.getters.absence;
    }
  }
};
</script>
