<template>
  <div class="wrapper">
    <side-bar>
      <template slot="links">
        <sidebar-link to="/dashboard" name="Tableau de bord" icon="ti-panel" v-if="checkPermission('SEE_MENU_DASHBOARD')" />
        <!--<sidebar-link to="/stats" name="User Profile" icon="ti-user"/>-->
        <!--<sidebar-link to="/table-list" name="Table List" icon="ti-view-list-alt"/>
        <sidebar-link to="/typography" name="Typography" icon="ti-text"/>
        <sidebar-link to="/icons" name="Icons" icon="ti-pencil-alt2"/>
        <sidebar-link to="/maps" name="Map" icon="ti-map"/>-->

        <sidebar-link to="/notes" name="Notes" icon="fa fa-book" v-if="checkPermission('SEE_MENU_NOTE')"/>
        <sidebar-link to="/professeurs" name="Professeurs" icon="fa fa-users" v-if="checkPermission('SEE_MENU_PROFESSEUR')"/>
        <sidebar-link to="/classes" name="Classes" icon="fas fa-book-reader" v-if="checkPermission('SEE_MENU_CLASSE')"/>
        <sidebar-link to="/eleves" name="Eleves" icon="fas fa-user-graduate" v-if="checkPermission('SEE_MENU_ELEVE')"/>
        <sidebar-link to="/parents" name="Parents" icon="fas fa-user-tie" v-if="checkPermission('SEE_MENU_PARENT')"/>
        <sidebar-link to="/absences" name="Absences" icon="far fa-clock" v-if="checkPermission('SEE_MENU_ABSENCE')"/>
        <sidebar-link to="/abonnements" name="Abonnements" icon="fas fa-pen" v-if="checkPermission('SEE_MENU_ABONNEMENT')"/>
        <sidebar-link to="/moyennes" name="Moyennes" icon="ti-map" v-if="checkPermission('SEE_MENU_MOYENNE')"/>

        <!-- <sidebar-link to="/notifications" name="Notifications" icon="ti-bell" :sidebarLinks="sibebarslinks"/>-->
        <sidebar-link to="#/" name="Paramètre" icon="fas fa-cogs" v-if="checkPermission('SEE_MENU_PARAMETRE')">
          <template slot="souslinks">
            <!--<sous-sidebar-link to="/annees-scolaires" name="Années scolaires" icon="fas fa-cogs" />-->
            <sous-sidebar-link
              to="/sections-annee-scolaire"
              name="Sections Année"
              icon="fas fa-cogs"
              v-if="checkPermission('SEE_MENU_SECTIONANNEESCOLAIRE')"
            />
            <sous-sidebar-link to="/log-sms" name="Log sms" icon="fas fa-cogs" v-if="checkPermission('SEE_MENU_LOGSMS')"/>
            <!--<sous-sidebar-link to="/series" name="Series" icon="fas fa-cogs" />-->
            <!--<sous-sidebar-link to="/niveaux" name="Niveaux" icon="fas fa-cogs" />-->
            <!--<sous-sidebar-link to="/matieres" name="Matieres" icon="fas fa-cogs" />-->
            <!--<sous-sidebar-link to="/typesmoyennes" name="Type de moyennes" icon="fas fa-cogs" />-->
            <!--<sous-sidebar-link to="/raisonsabsences" name="Raisons d'absences" icon="fas fa-cogs" />-->
            <sous-sidebar-link to="/sms" name="SMS" icon="fas fa-cogs" v-if="checkPermission('SEE_MENU_SMS')"/>
            <sous-sidebar-link to="/roles" name="Rôles" icon="fas fa-cogs" v-if="checkPermission('SEE_MENU_ROLE')"/>
            <sous-sidebar-link to="/profil" name="Mon profil" icon="fas fa-cogs" v-if="checkPermission('SEE_MENU_PROFIL')"/>
            <sous-sidebar-link to="/users" name="Utilisateurs" icon="fas fa-cogs" v-if="checkPermission('SEE_MENU_USER')"/>
          </template>
        </sidebar-link>
      </template>
      <mobile-menu>
        <li class="nav-item">
          <a class="nav-link">
            <i class="ti-panel"></i>
            <p>Stats</p>
          </a>
        </li>
        <drop-down class="nav-item" title="5 Notifications" title-classes="nav-link" icon="ti-bell">
          <a class="dropdown-item">Notification 1</a>
          <a class="dropdown-item">Notification 2</a>
          <a class="dropdown-item">Notification 3</a>
          <a class="dropdown-item">Notification 4</a>
          <a class="dropdown-item">Another notification</a>
        </drop-down>
        <li class="nav-item">
          <a class="nav-link">
            <i class="ti-settings"></i>
            <p>Settings</p>
          </a>
        </li>
        <li class="divider"></li>
      </mobile-menu>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click.native="toggleSidebar"></dashboard-content>

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
import MobileMenu from "./MobileMenu";
export default {
  components: {
    TopNavbar,
    ContentFooter,
    DashboardContent,
    MobileMenu
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    }/*,
    checkPermission(permission) {
      let result = false;
      let permissions = this.permissions;
      if (permissions) {
        result = permissions.split(",").find(function(p) {
          return p == permission;
        });
        result = result == permission ? true : false;
      } else {
        result = false;
      }
      return result;
    }*/
  },
  data() {
    return {
      sibebarslinks: [{ to: "/log-sms", name: "Absences", icon: "ti-map" }],
      show: false
    };
  },
  created(){
    // this.sayHello();
  },
  computed: {
    permissions() {
      let permission = "ADD_NOTE";
      let permissions = this.$cookies.get("permissions");
      let result = permissions.split(",").find(function(p) {
        return p == permission;
      });
      result = result == permission ? true : false;
      console.log(result);
      return this.$cookies.get("permissions");
    }
  },
  watch: {
    permissions() {
      console.log("qvsdgvsqgd dqsdqsdqsd qsdsqd qsdqssqd qs");
    }
  }
};
</script>

<style scoped>
/*.nav-link p{
  font-family: Poppins-Medium !important;
}*/
.wrapper .sidebar .nav p {
  font-size: 13px;
}
/*body,
html {
  height: 100%;
  font-family: Poppins-Regular, sans-serif;
}*/

/*//////////////////////////////////////////////////////////////////
[ FONT ]*/

/*@font-face {
  font-family: Poppins-Regular;
  src: url("../assets/fonts/poppins/Poppins-Regular.ttf");
}

@font-face {
  font-family: Poppins-Bold;
  src: url("../assets/fonts/poppins/Poppins-Bold.ttf");
}

@font-face {
  font-family: Poppins-Medium;
  src: url("../assets/fonts/poppins/Poppins-Medium.ttf");
}

@font-face {
  font-family: Montserrat-Bold;
  src: url("../assets/fonts/montserrat/Montserrat-Bold.ttf");
}*/
</style>
