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
          <!--<li style="display: inline-block;">
            <router-link to="/create-parent">Create compte parent</router-link>
          </li>
           <li style="display: inline-block;">
            <router-link to="/create-parent">Create compte parent</router-link>
          </li> -->
          <li style="display: inline-block;">
            <router-link to="/absence-eleve">Absences</router-link>
          </li>
        </ul>
      </div>
      <div class="col-sm">
        <select name="" id="" class="form-control">
          <option>Sélectionner un élève afin de le suivre</option>
          <option value="">Eleve 1</option>
          <option value="">Eleve 2</option>
        </select>
      </div>
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
      email: localStorage.userEmail
    };
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
