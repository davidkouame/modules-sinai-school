<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12" v-if="abonnement">
          <form v-on:submit="saveAbonnement">
               <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Parent</label>
                      <!---->
                      <select v-model="abonnement.parent_id" class="form-control" >
                      <option value="">Sélectionnez un parent</option>
                      <option :value="parent.id" v-for="parent in parents">{{ parent.name }} {{ parent.surname }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Année scolaire</label>
                      <!---->
                      <select v-model="abonnement.annee_scolaire_id" class="form-control" >
                      <option value="">Sélectionnez une année scolaire</option>
                      <option :value="anneescolaire.id" v-for="anneescolaire in anneesscolaires">{{ anneescolaire.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Pack abonnement</label>
                      <!---->
                      <select v-model="abonnement.pack_abonnement_id" class="form-control" >
                      <option value="">Sélectionnez un pack</option>
                      <option :value="packabonnement.id" v-for="packabonnement in packsabonnement">{{ packabonnement.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Commentaire</label>
                      <!---->
                      <textarea class="form-control" v-model="abonnement.commentaire"></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <a id="show-modal" @click="openModalSearchEleve()" class="btn btn-primary" type="button" >Ajouter</a>
                  </div>
                  <table class="table table-d">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
          <tr v-if="eleve" v-for="(eleve, index) in eleves">
            <th scope="row">{{ index + 1}}</th>
            <td>{{ eleve.matricule  }}</td>
            <td>{{ eleve.name  }}</td>
            <td>{{ eleve.surname  }}</td>
            <td>
              <a id="show-modal" @click="removeEleve(index)" type="button" class="btn btn-icon btn-danger btn-sm">
                <!----><i class="fa fa-times"></i><!---->
              </a>
            </td>
          </tr>
          <tr v-show="showEmptySentenceAbonnement"><td colspan="6" style="text-align: center;">Aucun resultat trouvé !</td></tr>
        </tbody>
                  </table>
                  <modal
                  v-if="showModal"
                  @close="showModal = false"
                  v-bind:modelid="abonnementId"
                  modelname="abonnement"
                  nameUrl="abonnements"
                  modaltype="searchEleve"
                ></modal>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Modifier</button>
                    </div> 
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>

import moment from 'moment'

export default {
  data() {
    return {
      title: "Modifier un abonnement",
      showModal: false,
      abonnementId: 0,
      eleves: [],
      isLoader: false,
      valueDisabled: false
    };
  },
  created() {
    // recuperation de l'abonnement
    this.$store.dispatch("getAbonnement", {
      abonnementId: this.$route.params.id
    });
    // recuperation des eleves
    // this.$store.dispatch('getAllEleves', {payload: 0})
    // recuperation des années scolaires
    this.$store.dispatch('getAllAnneesScolaires', {payload: 0})
    // recuperation des packs d'abonnements
    this.$store.dispatch('getAllPacksAbonnement', {payload: 0})
    // recuperation des parents
    this.$store.dispatch('getAllParents', {payload: 0})
    // recuperation des eleves de l'abonnements
    this.$store.dispatch('getAllElevesAbonnement', {abonnementId: this.$route.params.id})
  },
  methods:{
    saveAbonnement(){
      this.valueDisabled = true;
      let data = {
        parent_id: this.abonnement.parent_id,
        annee_scolaire_id: this.abonnement.annee_scolaire_id,
        pack_abonnement_id: this.abonnement.pack_abonnement_id,
        commentaire: this.abonnement.commentaire,
        eleves: this.eleves
      };
      let store = this.$store;
      store
        .dispatch("updateAbonnementWithEleves", {"data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès")
          this.$router.go(-1)
        })
        .catch(error => {
          console.log(error);
          alert("echec lors de l'enregistrement")
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    },
    openModalSearchEleve() {
      this.showModal = true;
      this.abonnementId = 1;
    },
    removeEleve(index){
      this.eleves.splice(index, 1); 
    }
  },
  computed:{
    abonnement() {
      return this.$store.getters.abonnement;
    },
    anneesscolaires(){
      return this.$store.getters.anneesscolaires
    },
    packsabonnement(){
      return this.$store.getters.packsabonnement
    },
    parents(){
      return this.$store.getters.parents
    },
    eleve(){
      return this.$store.getters.chooseEleve
    },
    showEmptySentenceAbonnement(){
      return  this.notEmptyObject(this.eleves) == 0
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
