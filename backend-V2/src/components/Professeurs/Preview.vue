<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="professeur">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.nom"
                        disabled
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
                        v-model="professeur.prenom"
                        disabled
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
                        type="text"
                        v-model="professeur.email"
                        disabled
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
                        v-model="professeur.tel"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matière</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.matiere"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.reference"
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
                      <textarea class="form-control" v-model="professeur.description" disabled></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/professeurs" class="btn btn-danger float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail professeur",
    };
  },
  created() {
    this.$store.dispatch("getProfesseur", {
      professeurId: this.$route.params.id
    });
  },
  computed: {
    professeur() {
      return this.$store.getters.professeur;
    }
  }
};
</script>
