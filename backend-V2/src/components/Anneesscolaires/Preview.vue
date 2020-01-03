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
                <a href="#/annees-scolaires" class="btn btn-danger float-right" style="background: #EE2D20;color: #fff;opacity: 1;">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Année scolaire",
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
  }
};
</script>
