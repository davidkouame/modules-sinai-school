<template>
  <card class="card" :title="title">
    <div class="row">
      <div v-if="error" class="col-md-12">
        <message-error v-bind:error="error"></message-error>
      </div>

      <div class="col-md-12" v-if="role">
        <form v-on:submit="saveRole">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Libellé</label>
                <!---->
                <input
                  class="form-control"
                  type="text"
                  v-model="role.libelle"
                  placeholder="Libellé"
                />
                <!---->
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <ul v-for="menu in permissions['menus']">
            <h4>{{ menu.libelle }}</h4>
            <ul>
              <li v-for="permission in permissions['permissions'][menu.libelle]">
                <label :for="permission.id">{{ permission.libelle }}</label> <input type="checkbox" :id="permission.id" :value="permission.id" v-model="permis" :checked="isChecked"/>
              </li>
            </ul>
            <hr>
          </ul>
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
      title: "Modifier un rôle",
      validated_at: "",
      valueDisabled: false,
      error: null,
      permis: []
    };
  },
  created() {
    // recuperation du role
    this.$store.dispatch("getRole", {id: this.$route.params.id});

    // recuperation des permissions
    this.$store.dispatch('getPermissionsAll', {payload: 0});
  },
  methods: {
    saveRole() {
      this.valueDisabled = true;
      this.error = null;
      let data = {
        libelle: this.role.libelle,
        school_id: this.$cookies.get("ecoleId"),
        annee_scolaire_id: this.$cookies.get("anneeScolaireId"),
        permissions: this.permis
      };
      let store = this.$store;
      store
        .dispatch("updateModel", {
          url: "roles",
          data: data,
          id: this.$route.params.id
        })
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
    role() {
      return this.$store.getters.role;
    },
    permissions(){
      return this.$store.getters.permissions;
    },
    isChecked() {
    	return true;
    }
  },
  watch: {
    role(){
      let i = 0;
      for(i=0; i<this.role.permissions.length; i++){
        this.permis.push(this.role.permissions[i].id);
      }
    }
  }
};
</script>
