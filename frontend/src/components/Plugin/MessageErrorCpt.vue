<template>
    <div
    class="alert alert-danger alert-dismissible fade show col-md-12"
    v-show="ShowFlashError"
    role="alert"
    >
    <p v-html="msgErr"></p>
    <button
        type="button"
        class="close"
        data-dismiss="alert"
        aria-label="Close"
        @click="closeFlashError"
        style="opacity: .75;color: #000;"
    >
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: "Message erreur",
            msgErr: null,
            ShowFlashError: true
        };
    },
    props: {
        error: {
            default: null
        }
    },
    created(){
        this.msgErr = this.traitError(this.error);
    },
    methods: {
        closeFlashError() {
        this.ShowFlashError = false;
        }
    },
    
};
</script>
