<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-on:submit="saveParent">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="parent.name"
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
                        v-model="parent.surname"
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
                        v-model="parent.email"
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
                        v-model="parent.tel"
                        placeholder="Téléphone"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Pays</label>
                      <!---->
                      <select v-model="parent.pays_id" class="form-control" >
                      <option value="">Sélectionnez un pays</option>
                      <option :value="pay.id" v-for="pay in pays">{{ pay.libelle }}</option>
                      </select>
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
                        v-model="parent.create_account"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a> &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Envoyer</button>
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
      title: "Ajouter un parent",
      parent: {"name": "", "surname": "", "email": "", "tel": "", "create_account": "", "pays_id": ""},
      valueDisabled: false
    };
  },
  created(){
    this.$store.dispatch('getAllPays', {page: 0})
  },
  methods:{
    saveParent(){
      this.valueDisabled = true;
      let data = {
        name: this.parent.name,
        surname: this.parent.surname,
        email: this.parent.email,
        tel: this.parent.tel,
        pays_id: this.parent.pays_id,
        create_account: this.parent.create_account
      };
      let store = this.$store;
      store
        .dispatch("saveModel", {"url": "parents", "data": data})
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
    pays(){
      return this.$store.getters.pays
    }
  }
};
</script>
