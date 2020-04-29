<template>
  <div class="content">
    <div class="container-fluid">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link"
            id="user-connexion"
            data-toggle="tab"
            :class="{active:selected == 1}"
            href="javascript:void(0)"
            @click="selected = 1"
            role="tab"
            aria-controls="home"
            aria-selected="true"
          >User connexion</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 2}"
            @click="selected = 2"
            id="classes"
            data-toggle="tab"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >Classes</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            :class="{active:selected == 3}"
            @click="selected = 3"
            id="classes"
            data-toggle="tab"
            href="javascript:void(0)"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
          >App</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <br />

        <!-- Tab user connexion -->
        <div
          class="tab-pane fade"
          :class="{show:selected == 1,active:selected == 1}"
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
                  <a v-on:click="updateUser()" class="btn btn-primary float-right">Enregistrer</a>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab classes -->
        <div
          class="tab-pane fade"
          :class="{show:selected == 2,active:selected == 2}"
          id="profile"
          role="tabpanel"
          aria-labelledby="classes"
        >
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-d">
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
                          <td v-if="classe.classe.professeurprincipal">{{ classe.classe.professeurprincipal.nom }} {{ classe.classe.professeurprincipal.prenom }}</td>
                          <td></td>
                          <td>{{ classe.classe.nbre_eleve_id }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Information App -->
        <div
          class="tab-pane fade"
          :class="{show:selected == 3,active:selected == 3}"
          id="profile"
          role="tabpanel"
          aria-labelledby="classes"
        >
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <form>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Année Scolaire</label>
                      <div class="col-sm-10">
                        <select v-model="anneescolaire" class="form-control">
                            <option :value="annee" v-for="annee in anneesscolaires">{{ annee.libelle }}</option>
                        </select>
                      </div>
                    </div>
                    <a v-on:click="saveSessionUser()" class="btn btn-primary float-right">Enregistrer</a>
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
      confirmpassword: null,
      tel: null,
      selected: 1,
      anneescolaire: null
    };
  },
  created() {
    this.$store.dispatch("professeurP", this.$cookies.get("professeurId"));
    this.$store.dispatch("sessionuserapp", {user_id: this.$cookies.get("userId")});
    this.$store.dispatch("anneesscolaires");
    this.$store.dispatch(
      "getClassesByProfesseurIdP",
      this.$cookies.get("professeurId")
    );
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
          store.dispatch("raisonsabsences", response.data.data);
          alert("La mise à jour a été effectué avec succès !");
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement");
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
    saveSessionUser() {
      /*const data = new FormData();
      data.append("annee_scolaire_id", this.anneescolaire.id);
      data.append("user_id", this.$cookies.get("userId"));*/
      let dataSa = null;
      let data = {annee_scolaire_id: this.anneescolaire.id, 
                user_id: this.$cookies.get("userId")};
      if(this.sessionuserapp){
        dataSa = {id: this.sessionuserapp.id, data: data};
      }else{
        dataSa = {data: data};
        }
      let store = this.$store;
      // console.log("liste des params "+data);
      store
        .dispatch("saveSessionUserApp", dataSa)
        .then(response => {
          store.dispatch("sessionuserapp", response.data.data);
          store.dispatch("anneeScolaireId", this.anneescolaire.id);
          this.$cookies.set("anneeScolaireId", this.anneescolaire.id);
          alert("La mise à jour a été effectué avec succès !");
            window.location.reload();
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
    professeur() {
      return this.$store.getters.professeur;
    },
    classes() {
      return this.$store.getters.classes;
    },
    anneesscolaires() {
      return this.$store.getters.anneesscolaires;
    },
    sessionuserapp(){
        // console.log(">>>>>>>>>>"+JSON.stringify(this.$store.getters.sessionuserapp));
      return this.$store.getters.sessionuserapp;
    }
  },
  watch: {
    professeur: function() {
      this.username = this.professeur.users.name;
      this.email = this.professeur.users.email;
      this.tel = this.professeur.tel;
    },
    classes: function() {
      // console.log("chargement des classes " + this.classes);
    },
    anneesscolaires(){
        // console.log("la valeur de la session user app est"+JSON.stringify(this.sessionuserapp));
        // console.log("la valeur de la session de user app est "+this.sessionuserapp);
        if(this.sessionuserapp){
            // console.log("@@@@@@@@@@@");
            this.anneescolaire = this.sessionuserapp.anneescolaire;
        }else{
            this.anneescolaire = this.anneesscolaires[0];
        }
    },
    sessionuserapp(){
        this.anneescolaire = this.sessionuserapp.anneescolaire;
    }
  }
};
</script>