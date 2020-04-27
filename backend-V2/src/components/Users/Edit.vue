<template>
  <card class="card" :title="title">
    <div class="row">
      <!-- Show error message -->
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

      <div class="col-md-12" v-if="user">
        <form v-on:submit="saveUser">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Nom et prénoms (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <input type="text" class="form-control" v-model="user.name" />
                <!---->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Email (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <input type="email" class="form-control" v-model="user.email" />
                <!---->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Password (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <input type="password" class="form-control" v-model="password" />
                <!---->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Confirmation password (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <input type="password" class="form-control" v-model="password_confirmation" />
                <!---->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">
                  Rôle (
                  <span class="span-required">*</span>)
                </label>
                <!---->
                <select v-model="user.role_id" class="form-control">
                  <option value>Sélectionnez un rôle</option>
                  <option :value="role.id" v-for="role in roles">{{ role.libelle }}</option>
                </select>
                <!---->
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="float-right">
            <div class="row">
              <div class="col-md-12">
                <a @click="$router.go(-1)" class="btn btn-danger btn-delete">Annuler</a>
                &nbsp;
                <button
                  type="submit"
                  class="btn btn-primary btn-add"
                  :disabled="valueDisabled"
                >
                  Modifier
                  <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </card>
</template>

<script>
import moment from "moment";

export default {
  data() {
    return {
      title: "Modifier un user",
      showModal: false,
      userId: 0,
      isLoader: false,
      valueDisabled: false,
      error: null,
      password: null,
      password_confirmation: null
    };
  },
  created() {
    this.$store.dispatch("getUser", {
      id: this.$route.params.id
    });

    // Recuperation des rôles
    this.$store.dispatch('getRolesAll', {payload: 0, search : [
      {key: "school_id", value: this.$cookies.get('ecoleId')},
      {key: "annee_scolaire_id", value: this.$cookies.get('anneeScolaireId')}]})
  },
  methods: {
    saveUser() {
      this.valueDisabled = true;
      let data = {
        name: this.user.name,
        email: this.user.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
        role_id: this.user.role_id,
        ecole_id: this.$cookies.get("ecoleId"),
        annee_scolaire_id: this.$cookies.get("anneeScolaireId"),
        is_admin: 1
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {"url": "users", "data": data, "id": this.$route.params.id})
        .then(response => {
          alert("L'enregistrement a été éffectué avec succès");
          this.$router.go(-1);
        })
        .catch(error => {
          this.error = error;
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    }
  },
  computed: {
    user() {
      return this.$store.getters.user;
    },
    showEmptySentenceUser() {
      return this.notEmptyObject(this.users) == 0;
    },
    roles(){
      return this.$store.getters.roles;
    }
  },
  watch: {}
};
</script>
