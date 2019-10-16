<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <!--<div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>-->

                    <div class="modal-body">
                        <slot name="body">
                            {{ getTextBody() }}
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="modal-default-button btn btn-primary" @click="$emit('close')">
                                Non
                            </button>
                            <button class="modal-default-button btn btn-danger" v-on:click="deleteModel">
                                Oui
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
  name: 'Modal',
  props: ['modelid', 'modelname'],
  data: function () {
    return {
      showModal: false
    }
  },
  created () {
    console.log('la noteid est ' + this.modelid)
    console.log('le nom du model est '+ this.modelname)
  },
  methods: {
    getTextBody(){
      let textBody = null;
      if(this.modelname == 'note'){
        textBody = "Voulez vous supprimer cette note ?"
      }else{
        textBody = "Voulez vous supprimer cette absence ?"
      }
      return textBody
    },
    deleteModel() {
      if(this.modelname == 'note'){
        // this.showModal = false
      this.$store.dispatch('deleteNote', this.modelid).then(response => {
        this.$emit('close')
        alert("L'enregistrement a été supprimé avec succès")
        //  this.$router.push('/notes')
          location.reload()
      })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
      }else{
        // this.showModal = false
      this.$store.dispatch('deleteAbsenceEleve', this.modelid).then(response => {
        this.$emit('close')
        alert("L'absence a été supprimé avec succès")
        //  this.$router.push('/absences-eleves')
          location.reload()
      })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
      }
    }
  }
}
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 300px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

</style>
