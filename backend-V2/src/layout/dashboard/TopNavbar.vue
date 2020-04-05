<template>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{routeName}}</a>
      <button class="navbar-toggler navbar-burger"
              type="button"
              @click="toggleSidebar"
              :aria-expanded="$sidebar.showSidebar"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-bar"></span>
        <span class="navbar-toggler-bar"></span>
        <span class="navbar-toggler-bar"></span>
      </button>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <!--<drop-down class="nav-item"
                     title="5 Notifications"
                     title-classes="nav-link"
                     icon="ti-bell">
            <a class="dropdown-item" href="#">Notification 1</a>
            <a class="dropdown-item" href="#">Notification 2</a>
            <a class="dropdown-item" href="#">Notification 3</a>
            <a class="dropdown-item" href="#">Notification 4</a>
            <a class="dropdown-item" href="#">Another notification</a>
          </drop-down>-->
          <!--<li class="nav-item">
            <a href="#/settings" class="nav-link">
              <i class="ti-settings"></i>
              <p>
                Paramètre
              </p>
            </a>
          </li>-->
          <li class="nav-item">
            <a @click="logout" class="btn btn-primary nav-link" style="background: #15477A;border-color: #15477A;color: #fff;">
              Déconnexion
            </a>
          </li>
        </ul>
      </div>
    </div></nav>
</template>
<script>
export default {
  computed: {
    routeName() {
      const { name } = this.$route;
      return this.capitalizeFirstLetter(name);
    }
  },
  data() {
    return {
      activeNotifications: false
    };
  },
  methods: {
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    toggleNotificationDropDown() {
      this.activeNotifications = !this.activeNotifications;
    },
    closeDropDown() {
      this.activeNotifications = false;
    },
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    },
    hideSidebar() {
      this.$sidebar.displaySidebar(false);
    },
    logout(){
      this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie))
      window.location.reload();
    }
  }
};
</script>
<style>
</style>
