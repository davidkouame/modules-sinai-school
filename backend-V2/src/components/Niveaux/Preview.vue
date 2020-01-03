<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="niveau">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="niveau.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Ordre</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="niveau.ordre"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/niveaux" class="btn btn-danger float-right" style="background: #EE2D20;color: #fff;opacity: 1;">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Niveau",
    };
  },
  created() {
    this.$store.dispatch("getNiveau", {
      niveauId: this.$route.params.id
    });
  },
  computed: {
    niveau() {
      return this.$store.getters.niveau;
    }
  }
};
</script>
