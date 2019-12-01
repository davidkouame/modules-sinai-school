<template>
  <div class="content">
    <div class="container-fluid">
      <div v-if="eleve">
        <div class="tab-content" id="myTabContent">
          <br />

          <!-- Tab user connexion -->
          <div
            class="tab-pane fade show active"
            id="home"
            role="tabpanel"
            aria-labelledby="user-connexion"
          >
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <form>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input v-model="username" type="text" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input v-model="email" type="text" class="form-control" disabled />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tel</label>
                      <div class="col-sm-10">
                        <input v-model="tel" type="text" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input v-model="password" type="password" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Confirm password</label>
                      <div class="col-sm-10">
                        <input v-model="password_confirmation" type="password" class="form-control" />
                      </div>
                    </div>
                    <a v-on:click="updateUser()" class="float-right btn btn-primary">Enregistrer</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ParametreUser",
  data() {
    return {
      username: null,
      email: null,
      password: null,
      password_confirmation: null,
      tel: null
    };
  },
  created() {
    this.$store.dispatch("eleve", localStorage.getItem("eleveId"));
  },
  methods: {
    updateUser() {
      const data = new FormData();
      data.append("username", this.username);
      data.append("tel", this.tel);
      data.append("email", this.email);
      if (this.password) {
        data.append("password", this.password);
        data.append("password_confirmation", this.password_confirmation);
      }
      let store = this.$store;
      store
        .dispatch("updateUser", data)
        .then(response => {
          // store.dispatch("raisonsabsences", response.data.data);
          alert("La mise à jour a été effectué avec succès !");
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement");
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    eleve() {
      return this.$store.getters.eleve;
    }
  },
  watch: {
    eleve: function() {
      this.username = this.eleve.user.name;
      this.email = this.eleve.user.email;
      this.tel = this.eleve.tel;
    }
  }
};
</script>