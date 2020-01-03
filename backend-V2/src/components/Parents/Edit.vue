<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="parent">
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
                      <label class="control-label">Matricule</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="parent.matricule"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
      <button type="submit" class="btn btn-primary">Modifier</button>
              </form>
        </div>
      </div>
  </card>
</template>

<script>


export default {
  data() {
    return {
      title: "Parent"
    };
  },
  created() {
  // recuperation du parent
    this.$store.dispatch("getParent", {
      parentId: this.$route.params.id
    });
  },
  methods:{
    saveParent(){
      let data = {
        name: this.parent.name,
        surname: this.parent.surname,
        email: this.parent.email,
        tel: this.parent.tel
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "parents", "data": data, "id": this.$route.params.id})
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
    parent() {
      // console.log("parent "+JSON.stringify(this.$store.getters.parent))
      return this.$store.getters.parent;
    }
  }
};
</script>
