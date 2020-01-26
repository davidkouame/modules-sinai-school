<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="typemoyenne">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="typemoyenne.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/typesmoyennes" class="btn btn-danger float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail Type moyenne",
    };
  },
  created() {
    this.$store.dispatch("getTypeMoyenne", {
      id: this.$route.params.id
    });
  },
  computed: {
    typemoyenne() {
      return this.$store.getters.typemoyenne;
    }
  }
};
</script>
