<template>
  <div class="container">
    <h1>Information de la classe</h1>
    <div class="row">
      <div class="col-sm">Libelle : {{ libelle }}</div>
      <div class="col-sm">Niveau : {{ niveau }}</div>
      <div class="col-sm">Serie : {{ serie }}</div>
    </div>
    <div class="row">
      <div class="col-sm">
        Emplois du temps
        <br>
        <img :src="'data:image/png;base64,'+emploisDuTemps" alt>
      </div>
    </div>
      <a :href="'#/'" class="btn btn-primary">retour</a>
  </div>
</template>

<script>
export default {
  name: "Classe",
  created() {
    this.$store.dispatch("classe", 9);
  },
  computed: {
    classe() {
      return this.$store.getters.classe
        ? this.$store.getters.classe.libelle
        : null;
    },
    libelle() {
      return this.$store.getters.classe
        ? this.$store.getters.classe.libelle
        : null;
    },
    niveau() {
      return this.$store.getters.classe && this.$store.getters.classe.niveau
        ? this.$store.getters.classe.niveau.libelle
        : null;
    },
    serie() {
      // console.log("log classe"+JSON.stringify(this.$store.getters));
      return this.$store.getters.classe && this.$store.getters.classe.serie
        ? this.$store.getters.classe.serie.libelle
        : null;
    },
    emploisDuTemps() {
      return this.$store.getters.classe
        ? this.$store.getters.classe.emploitemps
        : null;
    }
  }
};
</script>