<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="abonnement">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Parent</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="abonnement.parent ? abonnement.parent.name+' '+abonnement.parent.surname : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="abonnement.anneescolaire ? abonnement.anneescolaire.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Pack abonnement</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="abonnement.packabonnement ? abonnement.packabonnement.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Commentaire</label>
                      <!---->
                      <textarea class="form-control" v-model="abonnement.commentaire" disabled></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nombre de sms initial</label>
                      <input v-model="abonnement.nbre_sms_initial" class="form-control" disabled/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nombre de sms consomé</label>
                      <input v-model="abonnement.nbre_sms_consomme" class="form-control" disabled/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nombre de sms restant</label>
                      <input v-model="abonnement.nbre_sms_restant" class="form-control" disabled/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <table class="table table-d">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                      </tr>
                    </thead>
                    <tbody>
          <tr v-if="eleve" v-for="(eleve, index) in eleves">
            <th scope="row">{{ index + 1}}</th>
            <td>{{ eleve.matricule  }}</td>
            <td>{{ eleve.name  }}</td>
            <td>{{ eleve.surname  }}</td>
          </tr>
        </tbody>
                  </table>
                </div>
                <div class="clearfix"></div>
                <a href="#/abonnements" class="btn btn-danger btn-delete float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail abonnement",
      isLoader: false,
      eleves: [],
    };
  },
  created() {
    this.$store.dispatch("getAbonnement", {
      abonnementId: this.$route.params.id
    });
    // recuperation des eleves de l'abonnements
    this.$store.dispatch('getAllElevesAbonnement', {abonnementId: this.$route.params.id})
  },
  computed:{
    abonnement() {
      return this.$store.getters.abonnement;
    },
    elevesComputed(){
      return this.$store.getters.elevesabonnement
    }
  },
  watch:{
    eleve(){
      this.eleves.push(this.eleve)
    },
    elevesComputed(){
      if(this.elevesComputed && !this.isLoader){
        var i = 0
        for(i = 0; i < this.elevesComputed.length; i++){
          this.eleves.push(this.elevesComputed[i])
        }
        this.isLoader = true
      }
    }
  }
};
</script>
