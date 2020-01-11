<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="matiere">
          <form v-on:submit="saveMatiere">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="matiere.libelle"
                        placeholder="Libellé"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Type de matière</label>
                      <!---->
                      <select v-model="matiere.typematiere_id" class="form-control" >
                      <option value="">Sélectionnez un type de matiere</option>
                      <option :value="typematiere.id" v-for="typematiere in typesmatiere">{{ typematiere.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="matiere.description"></textarea>
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
                      <button type="submit" class="btn btn-primary">Modifier</button>
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
      title: "Modifier une serie",
      validated_at: "17/11/1973"
    };
  },
  created() {
  // recuperation de l'année scolaire
    this.$store.dispatch("getMatiere", {
      matiereId: this.$route.params.id
    });
    // recuperation de tous les types de matieres
    this.$store.dispatch('getAllTypesMatiere', {payload: 0})
  },
  methods:{
    saveMatiere(){
      let data = {
        libelle: this.matiere.libelle,
        typematiere_id: this.matiere.typematiere_id,
        description: this.matiere.description
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "matieres", "data": data, "id": this.$route.params.id})
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
  },
  computed:{
    typesmatiere(){
      return this.$store.getters.typesmatiere
    },
    matiere() {
      return this.$store.getters.matiere;
    }
  }
};
</script>
