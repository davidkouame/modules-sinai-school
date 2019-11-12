<template>
  <div id="app" class="container">
    <div class="row">
      <div class="col-sm">Username: {{ username }} <br> Email: {{ email }}</div>
    </div>
    <div class="row">
      <div class="col-sm">
        <select v-model="eleveId" class="form-control" id="select-eleve">
          <option selected>Sélectionner un élève</option>
          <option
            v-for="eleve in eleves"
            :value="eleve.id"
          >{{ eleve.users.name }}</option>
        </select>
      </div>
      <div class="col-sm">
        <ul>
          <li style="display: inline-block;">
            <router-link to="/">Home</router-link>
          </li>
          <li style="display: inline-block;">
            <router-link to="/notes">Notes</router-link>
          </li>
          <li style="display: inline-block;">
            <router-link to="/absences">Absences</router-link>
          </li>
          <li style="display: inline-block;">
            <router-link to="/matieres">Matières</router-link>
          </li>
          <li style="display: inline-block;">
            <router-link to="/parametres">Paramétrage</router-link>
          </li>
          
        </ul>
      </div>
      <div class="col-sm"><button v-on:click="logout">Logout</button></div>
    </div>
    <router-view/>
  </div>
</template>

<script>
export default {
  name: "Parent",
  data() {
    return {
      username: localStorage.userName,
      email: localStorage.userEmail, 
      eleveId: null
    };
  },
  created() {
    this.$store.dispatch('loadElevesByProfesseurId', 
    localStorage.getItem('parentId'));
  },
  methods: {
    logout: function(){
      // nous devons externaliser la fonctionn de déconnexion et de connexion
      localStorage.userId = "";
      localStorage.userName = "";
      localStorage.userEmail = "";
      localStorage.userType  = "";
      window.location.reload();
    }
  },
  computed:{
    eleves(){
      return this.$store.getters.eleves
    }
  },
  watch:{
    eleveId(){
      this.$store.dispatch('eleveId', this.eleveId);
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
