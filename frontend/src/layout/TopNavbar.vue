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
          <!--<li class="nav-item">
            <a class="nav-link" href="#/parametres">Compte</a>
          </li>-->
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
            <a v-for="eleve in eleves" class="dropdown-item" href="javascript:void(0)"
                @click="changeEleve(eleve)">{{ eleve.user.name }} {{ eleve.user.surname }}
                <i class="fa fa-check"  :class="{check:eleve.id == eleveId}" ></i>
            </a>
            <!--<a class="dropdown-item" href="javascript:void(0)" @click="changeEleve(0)">All</a>-->
          </base-dropdown>

          <base-dropdown v-bind:title="titleDropdownSection" v-if="sectionsanneescolaire && professeurId">
            <a v-for="section in sectionsanneescolaire" class="dropdown-item"
                href="javascript:void(0)" @click="changeSectionAnneeScolaire(section)">
              {{ section.libelle }}
              <i class="fa fa-check"  :class="{check:section.id == sectionAnneeScolaireId}" ></i>
            </a>
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
    },
    sectionsanneescolaire(){
      return this.$store.getters.sectionsanneescolaire;
    }
  },
  data() {
    return {
      activeNotifications: false,
        username: this.$cookies.get('userName'),
      email: this.$cookies.get('userEmail'),
      eleveId: null,
      titleDropdown: "Elèves",
      titleDropdownClasse: "Classes",
      parentId: this.$cookies.get('parentId') != "null",
      professeurId: this.$cookies.get('professeurId') != "null",
      classeId: null,
      sectionAnneeScolaireId: null,
      titleDropdownSection: null
    };
  },
  created() {
    // console.log("la valeur de section id a la création est "+this.sectionAnneeScolaireId);
    if(this.$cookies.get('parentId') && this.$cookies.get('parentId')!="null"){
      this.$store.dispatch('loadElevesByProfesseurId',
      this.$cookies.get('parentId'));
    }else{
      this.$store.dispatch('classes', [{'key': 'professeur_id', 'value': this.$cookies.get('professeurId')},
        {'key': 'annee_scolaire_id', 'value': this.$cookies.get('anneeScolaireId')}])

    }
    console.log("->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>")
    this.$store.dispatch('getAllSectionsAnneeScolaire', [{'key': 'annee_scolaire_id', 'value': this.$cookies.get('anneeScolaireId')}])
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
      this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie))
      window.location.reload();
    },
    changeEleve(eleve){
      this.$store.dispatch('eleveId', eleve.id);
      this.titleDropdown = eleve.user.name;
      this.eleveId = eleve.id;
      this.$cookies.set('eleveId', eleve.id);
      this.$router.push({ path: '/dashboard' })
    },
    changeClasse(classe){
      if(classe == 0){
        this.$store.dispatch('classeId', null);
        this.titleDropdownClasse = "Classes";
        this.classeId = 0;
      }else{
        this.$store.dispatch('classeId', classe.classe.id);
        this.titleDropdownClasse = classe.classe.libelle ;
        this.classeId = classe.classe.id;
      }
    },
    changeSectionAnneeScolaire(section){
        this.$store.dispatch('sectionAnneeScolaireId', section.id);
        this.titleDropdownSection = section.libelle ;
        this.sectionAnneeScolaireId = section.id;
        this.$cookies.set('sectionAnneeScolaireId', section.id);
        // this.$cookies.set('anneeScolaireId', section.annee_scolaire_id);
        // this.$router.push('#/dashboard');
        this.$router.push({ path: '/dashboard' })
    }
  },
  watch: {
    eleves() {
        if(this.parentId && this.eleves){
            this.eleveId = this.eleves[0].id;
            this.$store.dispatch('eleveId', this.eleves[0].id);
            this.$cookies.set('eleveId', this.eleves[0].id);
            this.titleDropdown = this.eleves[0].user ? this.eleves[0].user.name : null;
        }
    },
    sectionsanneescolaire(){
       // console.log(">>>>>>> "+JSON.stringify(this.sectionsanneescolaire));
       // this.sectionAnneeScolaire = this.$store.getters.sectionsanneescolaire[0].id;
       // this.titleDropdownSection = this.$store.getters.sectionsanneescolaire[0].libelle;
       let sectionAnneeScolaireId = this.$cookies.get('sectionAnneeScolaireId');
        if(this.$store.getters.sectionsanneescolaire){
            if(sectionAnneeScolaireId){
              if(sectionAnneeScolaireId!=-1){
                  var sectionAnneeScolaire = this.sectionsanneescolaire.find(function(element) {
                      if(element.id==sectionAnneeScolaireId){
                          return element;
                      }
                  });
                  // console.log("la section d'annee recherche est "+JSON.stringify(sectionAnneeScolaire))
                  if(sectionAnneeScolaire){
                    this.sectionAnneeScolaireId = sectionAnneeScolaire.id;
                    this.$cookies.set('sectionAnneeScolaireId', sectionAnneeScolaire.id);
                    this.$store.dispatch('sectionAnneeScolaireId', sectionAnneeScolaire.id);
                    this.$store.dispatch('anneeScolaireId', sectionAnneeScolaire.annee_scolaire_id);
                    this.titleDropdownSection = sectionAnneeScolaire.libelle;
                  }
                  // console.log("la valeur de section annee scolaire enregistre dans le stockage est "+JSON.stringify(sectionAnneeScolaire));
              }else{
                  this.sectionAnneeScolaireId = this.$store.getters.sectionsanneescolaire[0].id;
                  this.titleDropdownSection = this.$store.getters.sectionsanneescolaire[0].libelle;
                  this.$cookies.set('sectionAnneeScolaireId', this.sectionAnneeScolaireId);
                  this.$cookies.set('anneeScolaireId', this.$store.getters.sectionsanneescolaire[0].annee_scolaire_id);
                  this.$store.dispatch('sectionAnneeScolaireId', this.sectionAnneeScolaireId);
                  this.$store.dispatch('anneeScolaireId', this.$store.getters.sectionsanneescolaire[0].annee_scolaire_id);
              }
            }else{
              this.sectionAnneeScolaireId = this.$store.getters.sectionsanneescolaire[0].id;
              this.titleDropdownSection = this.$store.getters.sectionsanneescolaire[0].libelle;
              this.$cookies.set('sectionAnneeScolaireId', this.sectionAnneeScolaireId);
              this.$cookies.set('anneeScolaireId', this.$store.getters.sectionsanneescolaire[0].annee_scolaire_id);
              this.$store.dispatch('sectionAnneeScolaireId', this.sectionAnneeScolaireId);
              this.$store.dispatch('anneeScolaireId', this.$store.getters.sectionsanneescolaire[0].annee_scolaire_id);
            }
        }else{
            this.$cookies.set('sectionAnneeScolaireId', -1);
            this.$store.dispatch('sectionAnneeScolaireId', -1);
        }
        // console.log("la valeur de section id lors du changement est "+this.sectionAnneeScolaireId);
    }
  }
};
</script>
<style>
  .check{display: block !important}
  a .fa-check{display: none}
</style>
