<template>
  <div id="app">
    <!-- <img src="./assets/logo.png"> -->
     <nav>
      <div class="container">
        <ul class="nav__left">

          <!-- Navigation Links -->
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/test1">Test1</router-link></li>
          <li><router-link to="/test2">Test2</router-link></li>
          <li><router-link to="/test3">Test3</router-link></li>

        </ul>
      </div>
    </nav>
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
