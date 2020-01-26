<template>
  <card class="card" :title="title">
      <div class="row">

        <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

        <div class="col-md-12" v-if="parent">
          <form v-on:submit="saveParent">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Nom (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="parent.name"
                        placeholder="Nom"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Prénom (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="parent.surname"
                        placeholder="Prénom"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Email (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="email"
                        v-model="parent.email"
                        placeholder="Email"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Téléphone (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="parent.tel"
                        placeholder="Téléphone"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Matricule</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="parent.matricule"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Voulez réinitialiser le password ?</label>
                      <!---->
                      <input
                        class="form-control"
                        type="checkbox"
                        v-model="parent.create_account"
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Pays (
                  <span class="span-required">*</span>)</label>
                      <!---->
                      <select v-model="parent.pays_id" class="form-control" >
                      <option value="">Sélectionnez un pays</option>
                      <option :value="pay.id" v-for="pay in pays">{{ pay.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="float-right">
                  <div class="row">
                    <div class="col-md-12">
                      <a @click="$router.go(-1)" class="btn btn-danger">Annuler</a>
                      &nbsp;
                      <button type="submit" class="btn btn-primary" :disabled="valueDisabled">Modifier <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
                    </div> 
                  </div>
                </div>
              </form>
        </div>
      </div>
  </card>
</template>

<script>


export default {
  data() {
    return {
      title: "Modifier un parent",
      valueDisabled: false,
      error: null
    };
  },
  created() {
  // recuperation du parent
    this.$store.dispatch("getParent", {
      parentId: this.$route.params.id
    });
    this.$store.dispatch('getAllPays', {page: 0})
  },
  methods:{
    saveParent(){
      this.valueDisabled = true;
      this.error = null;
      let data = {
        name: this.parent.name,
        surname: this.parent.surname,
        email: this.parent.email,
        tel: this.parent.tel,
        pays_id: this.parent.pays_id,
        create_account: this.parent.create_account
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "parents", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été succès")
          this.$router.go(-1)
        })
        .catch(error => {
          this.errored = true;
          this.error = error;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed:{
    parent() {
      // console.log("parent "+JSON.stringify(this.$store.getters.parent))
      return this.$store.getters.parent;
    },
    pays(){
      return this.$store.getters.pays
    }
  }
};
</script>
