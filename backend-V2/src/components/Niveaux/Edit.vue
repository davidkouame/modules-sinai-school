<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="niveau">
          <form v-on:submit="saveNiveau">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="niveau.libelle"
                        placeholder="Libellé"
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
                        type="number"
                        v-model="niveau.ordre"
                        placeholder="Ordre"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Modifier</button>
                    </div> 
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>

import moment from 'moment'

export default {
  data() {
    return {
      title: "Modifier un niveau",
      validated_at: "17/11/1973",
      valueDisabled: false
    };
  },
  created() {
    this.$store.dispatch("getNiveau", {
      niveauId: this.$route.params.id
    });
  },
  methods:{
    saveNiveau(){
      this.valueDisabled = true;
      let data = {
        libelle: this.niveau.libelle,
        ordre: this.niveau.ordre,
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "niveaux", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    niveau() {
      return this.$store.getters.niveau;
    }
  }
};
</script>
