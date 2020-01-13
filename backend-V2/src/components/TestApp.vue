<template>
	<div class="container-fluid">
		<a @click="generateBilanAndSend" class="btn btn-primary">Générer bilan & envoyer </a>
		<button @click="generateBillanPeriodique" class="btn btn-primary" :disabled="valueDisabled">Send billan périodique</button>
		
		<div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Section année scolaire</label>
                      <!---->
                      <select v-model="sectionAnneeScolaireId" class="form-control" >
                      <option :value="sectionanneescolaire.id" v-for="sectionanneescolaire in sectionsanneescolaire">{{ sectionanneescolaire.libelle }}</option>
                      </select>
                      <!---->
                    </div>
                  </div>

	</div>
</template>

<script>
export default{
	name: "TestApp",
	data(){
		return {
			app: "test",
			sectionAnneeScolaireId: 1,
			valueDisabled: false
		}
	},
	created(){
		// recuperation de toutes les sections
    	this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0})
	},
	methods:{
		generateBilanAndSend(){
			this.$store.dispatch('generateBilanAndSend', {sectionAnneeScolaireId: this.sectionAnneeScolaireId})
		},
		generateBillanPeriodique(){
			this.valueDisabled = true;
			// console.log("ddd");
			this.$store.dispatch('generateBilanPeriodique', {sectionAnneeScolaireId: this.sectionAnneeScolaireId});
		}
	},
	computed:{
		sectionsanneescolaire(){
			return this.$store.getters.sectionsanneescolaire;
		}
	}
}
</script>