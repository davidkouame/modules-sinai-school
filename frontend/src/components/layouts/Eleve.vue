<template>
  <div id="app" class="container">
    <div class="row">
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
            <router-link to="/classe">Classe</router-link>
          </li>
          <!-- <li style="display: inline-block;">
            <router-link to="/create-parent">Create compte parent</router-link>
          </li> -->
          <li style="display: inline-block;">
            <router-link to="/absence-eleve">Absences</router-link>
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
  name: "Eleve",
  data() {
    return {
      username: localStorage.userName,
      email: localStorage.userEmail
    };
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
