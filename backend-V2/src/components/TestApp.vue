<template>
	<div class="container-fluid">
		<a @click="generateBilanAndSend" class="btn btn-primary">Générer bilan & envoyer </a>
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
		}
	}
}
</script>