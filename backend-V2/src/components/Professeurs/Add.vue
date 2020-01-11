<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-on:submit="saveProfesseur">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="professeur.nom"
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
                        v-model="professeur.prenom"
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
                        type="text"
                        v-model="professeur.email"
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
                        v-model="professeur.tel"
                        placeholder="Téléphone"
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
                        placeholder="Matière"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Créer un compte user</label>
                      <!---->
                      <input
                        class="form-control"
                        type="checkbox"
                        v-model="professeur.create_account"
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
                      <textarea class="form-control" v-model="professeur.description"></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary">Envoyer</button>
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
      title: "Ajouter un professeur",
      professeur: {"nom": "", "prenom": "", "email": "", "tel": "", "description": "", "matiere": "", "create_account": ""}
    };
  },
  methods:{
    saveProfesseur(){
      let data = {
        nom: this.professeur.nom,
        prenom: this.professeur.prenom,
        email: this.professeur.email,
        tel: this.professeur.tel,
        description: this.professeur.description,
        matiere: this.professeur.matiere,
        create_account: this.professeur.create_account,
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "professeurs", "data": data})
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
