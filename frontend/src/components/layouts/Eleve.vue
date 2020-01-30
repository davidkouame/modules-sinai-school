<template>
  <div>
    <!--<div class="row">
      <div class="col-sm">Username: {{ username }} <br> Email: {{ email }}</div>
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
    </div>-->

    <router-view/>
  </div>
</template>

<script>
export default {
  name: "Eleve",
  data() {
    return {
      username: this.$cookies.get('userName'),
      email: this.$cookies.get('userEmail')
    };
  },
  methods: {
    logout: function(){
      // nous devons externaliser la fonctionn de déconnexion et de connexion
      this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie))
      window.location.reload();
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
