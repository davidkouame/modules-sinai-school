<template>
  <div class="wrapper">
    <side-bar>
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/dashboard">
        <i class="nc-icon nc-chart-pie-35"></i>
        <p>Tableau de bord</p>
      </sidebar-link>
      <sidebar-link to="/notes">
        <i class="nc-icon nc-bell-55"></i>
        <p>Notes</p>
      </sidebar-link>
      <sidebar-link to="/absences">
        <i class="nc-icon nc-bell-55"></i>
        <p>Absences</p>
      </sidebar-link>
      <sidebar-link to="/matieres">
        <i class="nc-icon nc-bell-55"></i>
        <p>Matières</p>
      </sidebar-link>
      <sidebar-link to="/moyennes">
        <i class="nc-icon nc-bell-55"></i>
        <p>Moyennes</p>
      </sidebar-link>
      <sidebar-link to="/parametres">
        <i class="nc-icon nc-bell-55"></i>
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
  name: "EleveLayout",
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
