<template>
  <div class="wrapper">
    <side-bar>
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/dashboard">
        <i class="ti-panel" aria-hidden="true"></i>
        <p>Tableau de bord</p>
      </sidebar-link>
      <sidebar-link to="/notes">
        <i class="fa fa-book" aria-hidden="true"></i>
        <p>Notes</p>
      </sidebar-link>
      <sidebar-link to="/absences">
        <i class="far fa-clock" aria-hidden="true"></i>
        <p>Absences</p>
      </sidebar-link>
      <sidebar-link to="/eleves">
        <i class="fas fa-user-graduate" aria-hidden="true"></i>
        <p>Eleves</p>
      </sidebar-link>
      <sidebar-link to="/moyennes">
        <i class="ti-map" aria-hidden="true"></i>
        <p>Moyennes</p>
      </sidebar-link>
      <sidebar-link to="/parametres">
        <i class="fas fa-cogs" aria-hidden="true"></i>
        <p>Paramètres</p>
      </sidebar-link>
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click="toggleSidebar"></dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>
<style lang="scss">
</style>
<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "./MobileMenu.vue";
export default {
  name: "ProfesseurLayout",
  components: {
    TopNavbar,
    ContentFooter,
    DashboardContent,
    MobileMenu
  },
  data() {
    return {
      username: this.$cookies.get('userName'),
      email: this.$cookies.get('userEmail')
    };
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },
    logout: function() {
      // nous devons externaliser la fonctionn de déconnexion et de connexion
      this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie))
      window.location.reload();
    }
  }
};
</script>


<style>
  
  .sidebar[data-color="black"]::after, body > .navbar-collapse[data-color="black"]::after {
    background: #15477A !important;
        background-size: auto;
    background-size: 150% 150%;

}

.sidebar::before, body > .navbar-collapse::before {
    opacity: 0.8;
    background: #000000;
}
</style>

