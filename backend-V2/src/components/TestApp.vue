<template>
	<div class="container-fluid">
		<a @click="generateBilanAndSend" class="btn btn-primary">Générer bilan & envoyer </a>
		<a @click="generateBillanPeriodique" class="btn btn-primary">Send billan périodique</a>
	</div>
</template>

<script>
export default{
	name: "TestApp",
	data(){
		return {
			app: "test"
		}
	},
	methods:{
		generateBilanAndSend(){
			this.$store.dispatch('generateBilanAndSend', {sectionAnneeScolaireId: 1})
		},
		generateBillanPeriodique(){
			this.$store.dispatch('generateBilanPeriodique', {sectionAnneeScolaireId: 1})
		}
	}
}
</script>