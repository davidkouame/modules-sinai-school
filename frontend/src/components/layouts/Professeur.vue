<template>
  <div id="app" class="container">
    <div class="row">
      <div class="col-sm">Username: {{ username }} <br> Email: {{ email }}</div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm">
        <select name="" id="" class="form-control">
          <option>Sélectionner une classe</option>
          <option
            :value="classe.id"
            v-for="classe in classes"
          >{{ classe.libelle }}</option>
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
          <!--<li style="display: inline-block;">
            <router-link to="/classe">Classe</router-link>
          </li>-->
          <li style="display: inline-block;">
            <router-link to="/eleves">Elèves</router-link>
          </li>
          <!--<li style="display: inline-block;">
            <router-link to="/create-parent">Create compte parent</router-link>
          </li>
           <li style="display: inline-block;">
            <router-link to="/create-parent">Create compte parent</router-link>
          </li> -->
          <li style="display: inline-block;">
            <router-link to="/absences-eleves">Absences</router-link>
          </li>
          <li style="display: inline-block;">
            <router-link to="/parametres">Paramètre</router-link>
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
  name: 'Professeur',
  data () {
    return {
      username: localStorage.userName,
      email: localStorage.userEmail
    }
  },
  methods: {
    logout: function () {
      // nous devons externaliser la fonctionn de déconnexion et de connexion
      window.localStorage.clear()
      window.location.reload()
    }
  },
  created () {
    this.$store.dispatch('classes')
  },
  computed: {
    classes () {
      return this.$store.getters.classes
    }
  }
}
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

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

</style>
