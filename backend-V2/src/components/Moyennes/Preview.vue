<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="moyenne">
                               <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Elève</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="moyenne.eleve.name && moyenne.eleve.surname? moyenne.eleve.name+' '+moyenne.eleve.surname : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matière</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="moyenne.matiere && moyenne.matiere.libelle? moyenne.matiere.libelle+' '+moyenne.matiere.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coéfficient de la moyenne</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="moyenne.coefficient_matiere"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coéfficient de la section</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="moyenne.coefficient_section"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Valeur</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="moyenne.valeur"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Rang</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="moyenne.rang"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Section année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="moyenne.sectionanneescolaire ? moyenne.sectionanneescolaire.libelle : '' "
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Classe</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="moyenne.classe ? moyenne.classe.libelle : '' "
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="moyenne.anneescolaire ? moyenne.anneescolaire.libelle : '' "
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Type de moyenne</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="moyenne.typemoyenne ? moyenne.typemoyenne.libelle : '' "
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <input
                        class="form-control"
                        type="text"
                        v-model="moyenne.reference"
                        disabled
                      />
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/moyennes" class="btn btn-danger float-right" >Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail moyenne",
    };
  },
  created() {
    this.$store.dispatch("getMoyenne", {
      moyenneId: this.$route.params.id
    });
  },
  computed: {
    moyenne() {
      return this.$store.getters.moyenne;
    }
  }
};
</script>
