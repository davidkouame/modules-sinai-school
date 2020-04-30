<template>
  <div class="limiter">
  </div>
</template>

<script>
import Axios from "axios";

export default {
  name: "CheckResetPassword",
  created() {
    let code = this.$route.params.code;
    this.$store
      .dispatch("checkCodeResetPassword", code)
      .then(response => {
        this.$router.push('/reset-password/'+response.data.data.user.id+'/'+response.data.data.code)
        // console.log(JSON.stringify(response.data.data.user));
        // console.log(JSON.stringify(response.data.data.code));
      })
      .catch(error => {
        console.log(error);
        this.errored = true;
      })
      .finally(() => (this.loading = false));
  }
};
</script>