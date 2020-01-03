<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-on:submit="saveSerie">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="serie.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
      <button type="submit" class="btn btn-primary">Envoyer</button>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Series",
      serie: {"libelle": ""}
    };
  },
  methods:{
    saveSerie(){
      let data = {
        libelle: this.serie.libelle,
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "series", "data": data})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>
