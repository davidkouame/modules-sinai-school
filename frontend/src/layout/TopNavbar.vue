<template>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#/">Tableau de bord</a>
      <button
        type="button"
        class="navbar-toggler navbar-toggler-right"
        :class="{toggled: $sidebar.showSidebar}"
        aria-controls="navigation-index"
        aria-expanded="false"
        aria-label="Toggle navigation"
        @click="toggleSidebar"
      >
        <span class="navbar-toggler-bar burger-lines"></span>
        <span class="navbar-toggler-bar burger-lines"></span>
        <span class="navbar-toggler-bar burger-lines"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="nav navbar-nav mr-auto">
          <!--<li class="nav-item">
            <a class="nav-link" href="#" data-toggle="dropdown">
              <i class="nc-icon nc-palette"></i>
            </a>
          </li>-->
          <!--<base-dropdown tag="li">
            <template slot="title">
              <i class="nc-icon nc-planet"></i>
              <b class="caret"></b>
              <span class="notification">5</span>
            </template>
            <a class="dropdown-item" href="#">Notification 1</a>
            <a class="dropdown-item" href="#">Notification 2</a>
            <a class="dropdown-item" href="#">Notification 3</a>
            <a class="dropdown-item" href="#">Notification 4</a>
            <a class="dropdown-item" href="#">Another notification</a>
          </base-dropdown>-->
          <!--<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nc-icon nc-zoom-split"></i>
              <span class="d-lg-block">&nbsp;Search</span>
            </a>
          </li>-->
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#/parametres">Compte</a>
          </li>
          <!--<base-dropdown title="Dropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something</a>
            <div class="divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </base-dropdown>-->
          
          <base-dropdown v-bind:title="titleDropdown" v-if="parentId">
            <a v-for="eleve in eleves" class="dropdown-item" href="javascript:void(0)" @click="changeEleve(eleve)">{{ eleve.user.name }}</a>
            <div class="divider"></div>
            <a class="dropdown-item" href="javascript:void(0)" @click="changeEleve(0)">All</a>
          </base-dropdown>

          <base-dropdown v-bind:title="titleDropdownClasse" v-if="professeurId">
            <a v-for="classe in classes" class="dropdown-item" href="javascript:void(0)" @click="changeClasse(classe)">{{ classe.classe.libelle }}</a>
            <div class="divider"></div>
            <a class="dropdown-item" href="javascript:void(0)" @click="changeClasse(0)">All</a>
          </base-dropdown>

          <li class="nav-item">
            <a href="javascript:void(0)" v-on:click="logout" class="nav-link">Déconnexion</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  computed: {
    routeName() {
      const { name } = this.$route;
      return this.capitalizeFirstLetter(name);
    },
    eleves(){
      return this.$store.getters.eleves
    },
    classes () {
      return this.$store.getters.classes
    }
  },
  data() {
    return {
      activeNotifications: false,
      username: localStorage.userName,
      email: localStorage.userEmail,
      eleveId: null,
      titleDropdown: "Elèves",
      titleDropdownClasse: "Classes",
      parentId: localStorage.getItem('parentId') != "null",
      professeurId: localStorage.getItem('professeurId') != "null"
    };
  },
  created() {
    if(localStorage.getItem('parentId') && localStorage.getItem('parentId')!="null"){
      this.$store.dispatch('loadElevesByProfesseurId', 
      localStorage.getItem('parentId'));
    }else{
      this.$store.dispatch('classes', [{'key': 'professeur_id', 'value': localStorage.getItem('professeurId')}])
    }
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
    logout: function() {
      // nous devons externaliser la fonctionn de déconnexion et de connexion
      localStorage.userId = "";
      localStorage.userName = "";
      localStorage.userEmail = "";
      localStorage.userType = "";
      window.location.reload();
    },
    changeEleve(eleve){
      if(eleve == 0){
        this.$store.dispatch('eleveId', null);
        this.titleDropdown = "Elèves";
        // alert("sdsvfd");
      }else{
        this.$store.dispatch('eleveId', eleve.id);
        this.titleDropdown = eleve.user.name;
      }
    },
    changeClasse(classe){
      if(classe == 0){
        this.$store.dispatch('classeId', null);
        this.titleDropdownClasse = "Classes";
      }else{
        this.$store.dispatch('classeId', classe.classe.id);
        this.titleDropdownClasse = classe.classe.libelle ;
      }
    }
  }
};
</script>
<style>
</style>
