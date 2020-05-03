<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="logsms">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de création</label>
                      <!---->
                      <textarea 
                        class="form-control"
                        disabled>{{ logsms.created_at|formatDate }}</textarea>
                      <!---->
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Parent</label>
                      <!---->
                      <input 
                        class="form-control"
                        v-bind:value="logsms.parent.name+' '+logsms.parent.surname"
                        disabled/>
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6" v-if="logsms.eleve">
                    <div class="form-group">
                      <label class="control-label">Elève</label>
                      <!---->
                      <input 
                        class="form-control"
                        v-bind:value="logsms.eleve.name+' '+logsms.eleve.surname"
                        disabled/>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Content</label>
                      <!---->
                      <textarea 
                        class="form-control"
                        rows="8"
                        disabled>{{ logsms.content }}</textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/log-sms" class="btn btn-danger btn-delete float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail log sms",
    };
  },
  created() {
    this.$store.dispatch("getLogSms", {
      logSmsId: this.$route.params.id
    });
  },
  computed: {
    logsms() {
      return this.$store.getters.logsms;
    }
  }
};
</script>
