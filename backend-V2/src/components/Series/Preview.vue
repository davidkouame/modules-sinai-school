<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="serie">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="serie.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/series" class="btn btn-danger btn-delete float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail serie",
    };
  },
  created() {
    this.$store.dispatch("getSerie", {
      serieId: this.$route.params.id
    });
  },
  computed: {
    serie() {
      return this.$store.getters.serie;
    }
  }
};
</script>
