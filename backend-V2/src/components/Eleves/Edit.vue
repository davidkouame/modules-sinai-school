<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="eleve">
          <form v-on:submit="saveEleve">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="eleve.name"
                        placeholder="Nom"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Prénom</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="eleve.surname"
                        placeholder="Prénom"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Email</label>
                      <!---->
                      <input
                        class="form-control"
                        type="email"
                        v-model="eleve.email"
                        placeholder="Email"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Téléphone</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="eleve.tel"
                        placeholder="Téléphone"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matricule</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="eleve.matricule"
                        disabled
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


export default {
  data() {
    return {
      title: "Modifier un élève",
      valueDisabled: false
    };
  },
  created() {
  // recuperation de l'élève
    this.$store.dispatch("getEleve", {
      eleveId: this.$route.params.id
    });
  },
  methods:{
    saveEleve(){
      this.valueDisabled = true;
      let data = {
        name: this.eleve.name,
        surname: this.eleve.surname,
        email: this.eleve.email,
        tel: this.eleve.tel
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "eleves", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
          this.valueDisabled = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    typeseleve(){
      return this.$store.getters.typeseleve
    },
    eleve() {
      return this.$store.getters.eleve;
    }
  }
};
</script>
