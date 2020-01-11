<template>
  <footer class="footer">
    <div class="container-fluid d-flex flex-wrap justify-content-between">
      <nav>
        <ul>
          <li>
            <router-link :to="{path:'/dashboard'}">Tableau de bord</router-link>
          </li>
        </ul>
      </nav>
      <div class="copyright d-flex flex-wrap">
        &copy; Tous droits reservés par &nbsp;
        <a href="https://ayauka.com" target="_blank"> Ayauka</a> &nbsp;2020.
      </div>
    </div>
  </footer>
</template>
<script>
export default {};
</script>
<style>
</style>
