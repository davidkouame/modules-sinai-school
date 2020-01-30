<template>
  <div id="app" class="container">
    <h1>Paramètre professeur</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="user-connexion" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">User connexion</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="classes" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Classes</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <br />

      <!-- Tab user connexion -->
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="user-connexion">
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
              <input v-model="email" type="text" class="form-control" disabled/>
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
          <a v-on:click="updateUser()" class="btn btn-primary">Enregistrer</a>
        </form>
      </div>

      <!-- Tab classes -->
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="classes">
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <thead>
              <tr>
                  <th scope="col">#</th>
                  <th scope="col">Libelle</th>
                  <th scope="col">Professeur principale</th>
                  <th scope="col">Nombre d'élève</th>
                </tr>
              </thead>
              <tbody>
              <tr v-if="classes" v-for="(classe, index) in classes">
                  <th scope="row">{{ index + 1}}</th>
                  <td>{{ classe.classe.libelle }}</td>
                  <td>{{ classe.classe.professeurprincipal.nom }} {{ classe.classe.professeurprincipal.prenom }} </td>
                  <td>{{ classe.classe.nbre_eleve_id }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ParametreUser",
  data(){
    return {
      username: null,
      email: null,
      password: null,
      confirmpassword: null,
      tel: null
    }
  },
  created(){
    this.$store.dispatch('professeur', this.$cookies.get('professeurId'));
    this.$store.dispatch('getClassesByProfesseurId', this.$cookies.get('professeurId'));
  },
  methods: {
    updateUser(){
      const data = new FormData();
      data.append('username', this.username);
      data.append('tel', this.tel);
      data.append('email', this.email);
      if(this.password){
        data.append('password', this.password);
        data.append('password_confirmation', this.password_confirmation);
      }
     let store = this.$store;
      store
        .dispatch("updateUser", data)
        .then(response => {
          store.dispatch("raisonsabsences", response.data.data);
          alert("La mise à jour a été effectué avec succès !");
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    professeur(){
      return this.$store.getters.professeur;
    },
    classes(){
      return this.$store.getters.classes;
    }
  },
  watch:{
    professeur: function(){
      this.username = this.professeur.users.name
      this.email = this.professeur.users.email
      this.tel = this.professeur.tel
    },
    classes: function(){
      console.log("chargement des classes "+this.classes);
    }
  }
};
</script>