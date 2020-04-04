<template>
  <card class="card" :title="title">
    <div class="row">
      <div class="col-md-12">
        <div>
          <ul v-if="ecolesms">
            <li>Nombre de sms intitial : {{ ecolesms.nbre_sms_initial }}</li>
            <li>Nombre de sms consomé :  {{ ecolesms.nbre_sms_consome }}</li>
            <li>Nombre de sms restant : {{ ecolesms.nbre_sms_restant }}</li>
          </ul>
          <button class="btn btn-primary" v-on:click="startSms()" v-if="ecolesms && !is_run">
            Start
            <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div>
          </button>
          <button class="btn btn-danger" v-on:click="stopSms()" v-if="ecolesms && is_run">
            Stop
            <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div>
          </button>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
import moment from "moment";

export default {
  data() {
    return {
      title: "Information sur les sms",
      valueDisabled: false,
      is_run: 0
    };
  },
  created() {
    this.$store.dispatch("ecolesms", this.$cookies.get('ecoleId'));
  },
  methods: {
    startSms(){
      this.valueDisabled = true;
      let ecolesms_id = this.ecolesms.id;
      this.$store.dispatch("updateStatutSms", {id: ecolesms_id, data: {is_run: 1}}).then(response => {
          alert("Le module SMS a été activé avec succès !");
          this.$router.push('/sms') ;
          this.valueDisabled = false;
          this.is_run = 1;
          // window.location.reload();
        })
        .catch(error => {
          console.log(error);
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));
    },
    stopSms(){
      this.valueDisabled = true;
      let ecolesms_id = this.ecolesms.id;
      this.$store.dispatch("updateStatutSms", {id: this.ecolesms.id, data: {is_run: 0}}).then(response => {
          alert("Le module SMS a été désactivé avec succès !");
          this.$router.push('/sms') ;
          this.valueDisabled = false;
          this.is_run = 0;
          // window.location.reload();
        })
        .catch(error => {
          console.log(error);
          this.errored = true;
          this.valueDisabled = false;
        })
        .finally(() => (this.loading = false));;
    },
  },
  computed: {
    ecolesms() {
      return this.$store.getters.ecolesms;
    }
  }
};
</script>
