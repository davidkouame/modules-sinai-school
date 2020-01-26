<template>
	<div class="container-fluid">
		<h2>Rapport</h2>
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
		<a @click="generateBilanAndSend" class="btn btn-primary">Générer bilan & envoyer </a> &nbsp;
		<button @click="generateBillanPeriodique" class="btn btn-primary" :disabled="valueDisabled">Send billan périodique <div v-bind:class="{'spinner-border-customize': valueDisabled}"></div></button>
		<hr>
		<h2>Sms</h2>
		<div class="row">
			<div class="col-md-4">
						<input type="text" v-model="telephoneSendSms" class="col-md-12" placeholder="Insérer un numéros avec indicatif"><br><br>
				<button @click="sendSmsTest" class="btn btn-primary" :disabled="valueDisabledSendTestSms">Test sms <div v-bind:class="{'spinner-border-customize': valueDisabledSendTestSms}"></div></button>
				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Section année scolaire</label>
					<!---->
					<select v-model="sectionAnneeScolaireForGenerateNoteId" class="form-control" >
					<option :value="sectionanneescolaire.id" v-for="sectionanneescolaire in sectionsanneescolaire">{{ sectionanneescolaire.libelle }}</option>
					</select>
					<!---->
				</div>
				<button @click="generateNotesForSection" class="btn btn-primary" :disabled="valueDisabledGenerateSectionNote">Générer des données de test <div v-bind:class="{'spinner-border-customize': valueDisabledGenerateSectionNote}"></div></button>
			</div>
			<div class="col-md-4" v-if="parametrageapp">
				<div v-if="parametrageapp.send_sms_statut">	
					<label for="" >Sms is enabled (click on stop to stop sms)</label> &nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0)" class="btn btn-danger" v-on:click="startOrStopSms(0)"  :disabled="valueDisabledStartOrStopSms">
						Stop sms <div v-bind:class="{'spinner-border-customize': valueDisabledStartOrStopSms}"></div>
					</a>
				</div>
				<div v-if="!parametrageapp.send_sms_statut">
					<label for="">Sms is disabled (click on start to start sms)</label> &nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0)" class="btn btn-success" v-on:click="startOrStopSms(1)" 
				 :disabled="valueDisabledStartOrStopSms">Start sms<div v-bind:class="{'spinner-border-customize': valueDisabledStartOrStopSms}"></div></a>
				</div>
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
			sectionAnneeScolaireForGenerateNoteId: 1,
			valueDisabled: false,
			valueDisabledStartOrStopSms: false,
			telephoneSendSms: null,
			valueDisabledSendTestSms: false,
			valueDisabledGenerateSectionNote: false,
		}
	},
	created(){
		// recuperation de toutes les sections
		this.$store.dispatch('getAllSectionsAnneeScolaire', {payload: 0})
		// chargement du parametrage app
		this.$store.dispatch("getParametrageApp", {
			parametrageappId: 1
		});
	},
	methods:{
		generateBilanAndSend(){
			this.$store.dispatch('generateBilanAndSend', {sectionAnneeScolaireId: this.sectionAnneeScolaireId})
		},
		generateBillanPeriodique(){
			this.valueDisabled = true;
			// console.log("ddd");
			this.$store.dispatch('generateBilanPeriodique', {sectionAnneeScolaireId: this.sectionAnneeScolaireId});
		},
		startOrStopSms(statut){
			this.valueDisabledStartOrStopSms = true;
			let data = {
				send_sms_statut: statut
			};
			let store = this.$store;
			store
			.dispatch("updateModel", {"url": "parametrages", "data": data, "id": 1})
			.then(response => {
				alert("L'enregistrement a été éffectué avec succès")
				window.location.reload();
			})
			.catch(error => {
				console.log(error);
				alert("echec lors de l'enregistrement")
				this.errored = true;
				this.valueDisabled = false;
			})
			.finally(() => (this.loading = false));
		},
		sendSmsTest(){
			if(this.parametrageapp.send_sms_statut == 0){
				alert("Please, Enabled sms module !");
				this.valueDisabledSendTestSms = false;
			}else{
				this.valueDisabledSendTestSms = true;
				this.$store.dispatch("sendTestSms", {"tel": this.telephoneSendSms, "message": "Test ayauka"})
			}
		},
		generateNotesForSection(){
			this.valueDisabledGenerateSectionNote = true;
			this.$store.dispatch("generateNotesForSection", {"sectionAnneeScolaireId": this.sectionAnneeScolaireForGenerateNoteId})
		}
	},
	computed:{
		sectionsanneescolaire(){
			return this.$store.getters.sectionsanneescolaire;
		},
		parametrageapp(){
			return this.$store.getters.parametrageapp;
		}
	}
}
</script>