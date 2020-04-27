<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="role">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="role.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
              <div class="float-right">
                <a href="#/roles" class="btn btn-danger">Retour</a>
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
      title: "Détail rôle",
    };
  },
  created() {
    this.$store.dispatch("getRole", {
      id: this.$route.params.id
    });
  },
  computed: {
    role() {
      return this.$store.getters.role;
    }
  },
  methods:{
    
  }
};
</script>
