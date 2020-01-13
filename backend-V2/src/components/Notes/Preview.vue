<template>
  <card class="card" :title="title">
      <div class="row">
        <div class="col-md-12">
          <form v-if="note">
                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Référence</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="note.reference"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Libellé</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="note.libelle"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Date de création</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-model="note.datenoteeffectue"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                      <label class="control-label">Type de note</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="note.typenote ? note.typenote.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                      <label class="control-label">Matière</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="note.matiere ? note.matiere.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Coefficient</label>
                      <!---->
                      <input
                        class="form-control"
                        type="number"
                        v-model="note.coefficient"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Classe</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="note.classe ? note.classe.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Section année scolaire</label>
                      <!---->
                      <input
                        class="form-control"
                        type="text"
                        v-bind:value="note.sectionanneescolaire ? note.sectionanneescolaire.libelle : ''"
                        disabled
                      />
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label">Description</label>
                      <!---->
                      <textarea class="form-control" v-model="note.description" disabled></textarea>
                      <!---->
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <a href="#/notes" class="btn btn-danger float-right">Retour</a>
              </form>
        </div>
      </div>
  </card>
</template>

<script>
export default {
  data() {
    return {
      title: "Détail note",
    };
  },
  created() {
    this.$store.dispatch("getNote", {
      noteId: this.$route.params.id
    });
  },
  computed: {
    note() {
      return this.$store.getters.note;
    }
  }
};
</script>
