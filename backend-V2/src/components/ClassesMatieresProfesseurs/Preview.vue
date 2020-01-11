<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="matiere">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="matiere.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Type de matière</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="matiere.typematiere.libelle"
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
                      <textarea class="form-control" v-model="matiere.description" disabled>{{ matiere.description }}</textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/matieres" class="btn btn-danger float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail classe matière",
    };
  },
  created() {
    this.$store.dispatch("getMatiere", {
      matiereId: this.$route.params.id
    });
  },
  computed: {
    matiere() {
      return this.$store.getters.matiere;
    }
  }
};
</script>
