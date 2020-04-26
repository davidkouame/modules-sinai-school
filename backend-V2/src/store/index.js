import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'
/*import storeParent from '@/components/pages/parents/store'
import storeEleve from '@/components/pages/eleves/store'
import storeProfesseur from '@/components/pages/professeurs/store'*/

Vue.use(Vuex)


// Cette fonction permet de formater l'url et de retourner une url
function getUrl(context, nameUrl, params){
  let concatParams = null
  if (params.search) {
    concatParams = params.search.map(function (elemen) {
      return elemen.key + '=' + elemen.value
    }).join('&')
  }
  let result = ""
  if(concatParams){
    result = context.state.endpoint + 'api/v1/'+ nameUrl +'?page=' + params.payload + '&' + concatParams
  }else{
    result = context.state.endpoint + 'api/v1/'+ nameUrl +'?page=' + params.payload
  }
  return result;
}

// Cette fonction permet recuperer des informations d'un model
// et de le persister à travers un dispatch
function getInformModel(context, modelId, nameUrl, modelDispatch){
  Axios.get(
        context.state.endpoint + 'api/v1/'+nameUrl+'/' + modelId
      )
        .then(response => {
          context.commit(modelDispatch, response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
}

export default new Vuex.Store({
  strict: false,
  state: {
    // endpoint: 'http://localhost:8888/modules-sinai-school/backend/',
    endpoint: 'http://localhost:8888/ayauka/backend/',
    // endpoint: 'http://monsitenet.com/modules-sinai-school/backend/',
    api: 'api/v1/note/',
    anneesscolaires: null,
    anneescolaire: null,
    typesanneescolaire: null,
    pageCount: 1,
    sectionsanneescolaire: null,
    sectionanneescolaire: null,
    matieres: null,
    typesmatiere: null,
    matiere: null,
    series: null,
    serie: null,
    niveaux: null,
    niveau: null,
    notes: null,
    note: null,
    typesnote: null,
    classes: null,
    classe: null,
    professeurs: null,
    professeur: null,
    parents: null,
    parent: null,
    eleves: null,
    eleve: null,
    classeprofesseurmatiere: null,
    classesprofesseursmatieres: null,
    sectionsanneescolaire: null,
    anneesscolaires: null,
    elevesclasses: null,
    eleveclasse: null,
    noteeleve: null,
    currentPage: null,
    countPage: null,
    totalElement: null,
    matiere: null,
    absences: null,
    absence: null,
    raisonsabsences: null,
    raisonabsence: null,
    classeeleve: null,
    moyennes: null,
    moyennesmatieres: null,
    moyennessections: null,
    moyenneannuelle: null,
    typesmoyenne: null,
    moyenne: null,
    alllogsms: null,
    logsms: null,
    abonnements: null,
    abonnement: null,
    packsabonnement: null,
    chooseEleve: null,
    elevesabonnement: null,
    pays: null,
    parametrageapp: null,
    typesmoyennes: null,
    typemoyenne: null,
    ecolesms: null,
    school: null,
  },
  mutations: {
    anneesscolaires(state, payload) {
      state.anneesscolaires = payload
    },
    anneescolaire(state, payload) {
      state.anneescolaire = payload
    },
    typesanneescolaire(state, typesanneescolaire) {
      state.typesanneescolaire = typesanneescolaire
    },
    pageCount(state, payload) {
      state.pageCount = payload
    },
    sectionsanneescolaire(state, sectionsanneescolaire) {
      state.sectionsanneescolaire = sectionsanneescolaire
    },
    sectionanneescolaire(state, sectionanneescolaire) {
      state.sectionanneescolaire = sectionanneescolaire
    },
    matieres(state, matieres) {
      state.matieres = matieres
    },
    typesmatiere(state, typesmatiere) {
      state.typesmatiere = typesmatiere
    },
    matiere(state, matiere) {
      state.matiere = matiere
    },
    series(state, series) {
      state.series = series
    },
    serie(state, serie) {
      state.serie = serie
    },
    niveaux(state, niveaux) {
      state.niveaux = niveaux
    },
    niveau(state, niveau) {
      state.niveau = niveau
    },
    notes(state, notes) {
      state.notes = notes
    },
    note(state, note) {
      state.note = note
    },
    typesnote(state, typesnote) {
      state.typesnote = typesnote
    },
    classes(state, classes) {
      state.classes = classes
    },
    classe(state, classe) {
      state.classe = classe
    },
    professeurs(state, professeurs) {
      state.professeurs = professeurs
    },
    eleve(state, eleve) {
      state.eleve = eleve
    },
    professeur(state, professeur) {
      state.professeur = professeur
    },
    eleves(state, eleves) {
      state.eleves = eleves
    },
    eleve(state, eleve) {
      state.eleve = eleve
    },
    classeprofesseurmatiere(state, classeprofesseurmatiere){
      state.classeprofesseurmatiere = classeprofesseurmatiere
    },
    classesprofesseursmatieres(state, classesprofesseursmatieres){
      state.classesprofesseursmatieres = classesprofesseursmatieres
    },
    sectionsanneescolaire(state, sectionsanneescolaire){
      state.sectionsanneescolaire = sectionsanneescolaire
    },
    anneesscolaires(state, anneesscolaires){
      state.anneesscolaires = anneesscolaires
    },
    elevesclasses(state, elevesclasses){
      state.elevesclasses = elevesclasses
    },
    eleveclasse(state, eleveclasse){
      state.eleveclasse = eleveclasse
    },
    noteeleve(state, noteeleve){
      state.noteeleve = noteeleve
    },
    currentPage(state, currentPage){
      state.currentPage = currentPage
    },
    countPage(state, countPage){
      state.countPage = countPage
    },
    totalElement(state, totalElement){
      state.totalElement = totalElement
    },
    matiere(state, matiere){
      state.matiere = matiere
    },
    parents(state, parents) {
      state.parents = parents
    },
    parent(state, parent) {
      state.parent = parent
    },
    absences(state, absences) {
      state.absences = absences
    },
    absence(state, absence) {
      state.absence = absence
    },
    raisonsabsences(state, raisonsabsences) {
      state.raisonsabsences = raisonsabsences
    },
    raisonabsence(state, raisonabsence) {
      state.raisonabsence = raisonabsence
    },
    classeeleve(state, classeeleve) {
      state.classeeleve = classeeleve
    },
    moyennes(state, moyennes) {
      state.moyennes = moyennes
    },
    moyennesmatieres(state, moyennesmatieres) {
      state.moyennesmatieres = moyennesmatieres
    },
    moyennessections(state, moyennessections) {
      state.moyennessections = moyennessections
    },
    moyenneannuelle(state, moyenneannuelle) {
      state.moyenneannuelle = moyenneannuelle
    },
    typesmoyenne(state, typesmoyenne) {
      state.typesmoyenne = typesmoyenne
    },
    moyenne(state, moyenne) {
      state.moyenne = moyenne
    },
    alllogsms(state, alllogsms) {
      state.alllogsms = alllogsms
    },
    logsms(state, logsms){
      state.logsms = logsms
    },
    abonnements(state, abonnements){
      state.abonnements = abonnements
    },
    abonnement(state, abonnement){
      state.abonnement = abonnement
    },
    packsabonnement(state, packsabonnement){
      state.packsabonnement = packsabonnement
    },
    chooseEleve(state, chooseEleve){
      state.chooseEleve = chooseEleve
    },
    elevesabonnement(state, elevesabonnement){
      state.elevesabonnement = elevesabonnement
    },
    pays(state, pays){
      state.pays = pays
    },
    parametrageapp(state, parametrageapp){
      state.parametrageapp = parametrageapp
    },
    typesmoyennes(state, typesmoyennes){
      state.typesmoyennes = typesmoyennes
    },
    typemoyenne(state, typemoyenne){
      state.typemoyenne = typemoyenne
    },
    ecolesms(state, ecolesms) {
      state.ecolesms = ecolesms
    },
    school(state, school) {
      state.school = school
    }
  },
  getters: {
    anneesscolaires: state => {
      return state.anneesscolaires
    },
    anneescolaire: state => {
      return state.anneescolaire
    },
    pageCount: state => {
      return state.pageCount
    },
    typesanneescolaire: state => {
      return state.typesanneescolaire
    },
    sectionsanneescolaire: state => {
      return state.sectionsanneescolaire
    },
    sectionanneescolaire: state => {
      return state.sectionanneescolaire
    },
    matieres: state => {
      return state.matieres
    },
    typesmatiere: state => {
      return state.typesmatiere
    },
    matiere: state => {
      return state.matiere
    },
    series: state => {
      return state.series
    },
    serie: state => {
      return state.serie
    },
    niveaux: state => {
      return state.niveaux
    },
    niveau: state => {
      return state.niveau
    },
    typesnote: state => {
      return state.typesnote
    },
    notes: state => {
      return state.notes
    },
    note: state => {
      return state.note
    },
    classes: state => {
      return state.classes
    },
    classe: state => {
      return state.classe
    },
    professeurs: state => {
      return state.professeurs
    },
    note: state => {
      return state.note
    },
    professeur: state => {
      return state.professeur
    },
    eleves: state => {
      return state.eleves
    },
    eleve: state => {
      return state.eleve
    },
    classeprofesseurmatiere: state => {
      return state.classeprofesseurmatiere
    },
    classesprofesseursmatieres: state => {
      return state.classesprofesseursmatieres
    },
    sectionsanneescolaire: state => {
      return state.sectionsanneescolaire
    },
    sectionAnneeScolaireId: state => {
      return state.sectionAnneeScolaireId
    },
    anneesscolaires: state => {
      return state.anneesscolaires
    },
    elevesclasses: state => {
      return state.elevesclasses
    },
    eleveclasse: state => {
      return state.eleveclasse
    },
    noteeleve: state => {
      return state.noteeleve
    },
    currentPage: state => {
      return state.currentPage
    },
    countPage: state => {
      return state.countPage
    },
    totalElement: state => {
      return state.totalElement
    },
    matiere: state => {
      return state.matiere
    },
    parents: state => {
      return state.parents
    },
    parent: state => {
      return state.parent
    },
    absences: state => {
      return state.absences
    },
    absence: state => {
      return state.absence
    },
    raisonsabsences: state => {
      return state.raisonsabsences
    },
    raisonabsence: state => {
      return state.raisonabsence
    },
    classeeleve: state => {
      return state.classeeleve
    },
    moyennes: state => {
      return state.moyennes
    },
    moyennesmatieres: state => {
      return state.moyennesmatieres
    },
    moyennessections: state => {
      return state.moyennessections
    },
    moyenneannuelle: state => {
      return state.moyenneannuelle
    },
    typesmoyenne: state => {
      return state.typesmoyenne
    },
    moyenne: state => {
      return state.moyenne
    },
    alllogsms: state => {
      return state.alllogsms
    },
    logsms: state => {
      return state.logsms
    },
    abonnements: state => {
      return state.abonnements
    },
    abonnement: state => {
      return state.abonnement
    },
    packsabonnement: state => {
      return state.packsabonnement
    },
    chooseEleve: state =>{
      return state.chooseEleve
    },
    elevesabonnement: state => {
      return state.elevesabonnement
    },
    pays: state => {
      return state.pays
    },
    parametrageapp: state => {
      return state.parametrageapp
    },
    typesmoyennes: state => {
      return state.typesmoyennes
    },
    typemoyenne: state => {
      return state.typemoyenne
    },
    ecolesms: state => {
      return state.ecolesms
    },
    school: state => {
      return state.school
    }
  },
  actions: {
    getAnneesScolaires(context, params) {
      let nameUrl = "anneesscolaires"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('anneesscolaires', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAnneesScolairesBySchoolId(context, params) {
      let nameUrl = "anneesscolaires"
      let school_id = null;
      let search = null;
      for (var key in params.search) {
        if(params.search[key].key == "school_id"){
          school_id = params.search[key].value;
        }else{
          search = params.search[key].value;
        }
      }
      let url = context.state.endpoint + "api/v1/anneesscolaires/get-by-school-id/"+school_id+"?page="+params.payload;
      if(search){
        url+="&search="+search;
      }
      Axios.get(url)
        .then(response => {
          console.log()
          context.commit('anneesscolaires', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAnneeScolaireAfterlogin(context, schoolId){
      let url = context.state.endpoint + "api/v1/anneesscolaires/get-by-school-id/"+schoolId;
      return Axios.get(url);
    },
    getSectionsAnneeScolaire(context, params) {
      let nameUrl = "sectionsanneescolaire"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('sectionsanneescolaire', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAnneeScolaire(context, params) {
      getInformModel(context, params.anneeScolaireId, "anneesscolaires", "anneescolaire")
    },
    getAnneeScolaireBySchoolId(context, params) {
      // getInformModel(context, params.anneeScolaireId, "anneesscolaires", "anneescolaire")
      Axios.get(
        context.state.endpoint + 'api/v1/anneescolaire/get-by-school-id/' + params.anneeScolaireId + '/' + params.schoolId
      )
        .then(response => {
          context.commit("anneescolaire", response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    saveModel(context, params) {
      return Axios.post(
        context.state.endpoint + 'api/v1/'+params.url, params.data,
        { headers: { 'Content-Type': 'application/json' } }
      )
    },
    updateModel(context, params){
      // console.log("data "+JSON.stringify(params.data))
      return Axios.put(
        context.state.endpoint + 'api/v1/'+params.url+'/'+params.id, params.data,
        { headers: { 'Content-Type': 'application/json' }  }
      )
    },
    validateModel(context, params){
      return Axios.put(
        context.state.endpoint + 'api/v1/'+params.url+'/validate/'+params.id, params.data,
        { headers: { 'Content-Type': 'application/json' }  }
      )
    },
    getAllTypesAnneeScolaire(context, params) {
      let nameUrl = "typesanneescolaire"
      let url = getUrl(context, nameUrl, params)
      // console.log("@@@@@@@@@@@@@@@@@@ "+url)
      Axios.get(url)
        .then(response => {
          // console.log(response.data.data)
          context.commit('typesanneescolaire', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllAnneesScolaires(context, params) {
      let nameUrl = "anneesscolaires"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('anneesscolaires', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
     getAllTypesMatiere(context, params) {
      let nameUrl = "typesmatiere"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('typesmatiere', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
     getAllTypesMoyenne(context, params) {
      let nameUrl = "typesmoyenne"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('typesmoyenne', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    deleteModel(context, params) {
      return Axios.get(
        context.state.endpoint + 'api/v1/'+params.url+'/' + params.id + '/delete'
      );
    },
    getSectionAnneeScolaire(context, params) {
      getInformModel(context, params.sectionAnneeScolaireId, "sectionsanneescolaire", "sectionanneescolaire")
    },
    getMatieres(context, params) {
      let nameUrl = "matieres"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('matieres', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getMatiere(context, params) {
      getInformModel(context, params.matiereId, "matieres", "matiere")
    },
    getSeries(context, params) {
      let nameUrl = "series"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('series', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getSerie(context, params) {
      getInformModel(context, params.serieId, "series", "serie")
    },
    getNiveaux(context, params) {
      let nameUrl = "niveaux"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('niveaux', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getNiveau(context, params) {
      getInformModel(context, params.niveauId, "niveaux", "niveau")
    },
    getNotes(context, params) {
      let nameUrl = "notemodel"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('notes', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getNote(context, params) {
      getInformModel(context, params.noteId, "notemodel", "note")
    },
    getAllTypesNote(context, params) {
      let nameUrl = "typesnotes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('typesnote', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllMatieres(context, params) {
      let nameUrl = "matieres"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('matieres', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllClasses(context, params) {
      let nameUrl = "classes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('classes', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllNiveaux(context, params) {
      let nameUrl = "niveaux"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('niveaux', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllSeries(context, params) {
      let nameUrl = "series"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('series', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllSectionsAnneeScolaire(context, params) {
      let nameUrl = "sectionsanneescolaire"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('sectionsanneescolaire', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getProfesseurs(context, params) {
      let nameUrl = "professeurs"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('professeurs', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getProfesseur(context, params) {
      getInformModel(context, params.professeurId, "professeurs", "professeur")
    },
    getClasses(context, params) {
      let nameUrl = "classes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('classes', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getClasse(context, params) {
      getInformModel(context, params.classeId, "classes", "classe")
    },
    getMatieresByClasse(context, param) {
      Axios.get(
        context.state.endpoint + 'api/v1/classesprofesseursmatieres?'+'classe_id='+param.classeId
      )
        .then(response => {
          context.commit('classesprofesseursmatieres', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getClasseProfesseurMatiere(context, params) {
      getInformModel(context, params.classeProfesseurMatiereId, "classesprofesseursmatieres", "classeprofesseurmatiere")
    },
    getAllProfesseurs(context, params) {
      let nameUrl = "professeurs"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('professeurs', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllElevesClasses(context, params) {
      let nameUrl = "elevesclasses"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('elevesclasses', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getEleveClasse(context, params) {
      getInformModel(context, params.eleveClasseId, "elevesclasses", "eleveclasse")
    },
    getElevesClasses(context, params) {
      let nameUrl = "elevesclasses"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('elevesclasses', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllEleves(context, params) {
      let nameUrl = "eleves-customise"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('eleves', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getEleves(context, params) {
      let nameUrl = "eleves"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('eleves', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getEleve(context, params) {
      getInformModel(context, params.eleveId, "eleves", "eleve")
    },
    getParents(context, params) {
      let nameUrl = "parents"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('parents', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getParent(context, params) {
      getInformModel(context, params.parentId, "parents", "parent")
    },
    getAllParents(context, params) {
      let nameUrl = "parents"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('parents', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAbsences(context, params) {
      let nameUrl = "absenceseleves"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('absences', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAbsence(context, params) {
      getInformModel(context, params.absenceId, "absenceseleves", "absence")
    },
    saveElevesClasse(context, params) {
      return Axios.post(
        context.state.endpoint + 'api/v1/elevesclasses/save-eleves', params.data,
        { headers: { 'Content-Type': 'application/json' } }
      )
    },
    getAllRaisonsAbsences(context, params) {
      let nameUrl = "raisonsabsences"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('raisonsabsences', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getNotesWithValues(context, params){
      let nameUrl = "get-notes-v4"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('notes', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getClasseEleve(context, params) {
      getInformModel(context, params.classeEleveId, "elevesclasses", "classeeleve")
    },
    getMoyenne(context, params) {
      getInformModel(context, params.moyenneId, "moyennes", "moyenne")
    },
    addValueNote(context, data) {
        return Axios.put(
          context.state.endpoint + 'api/v1/noteseleves-valeur/' + data.eleve_id
             + '/' + data.note_id, data,
          { headers: { 'Content-Type': 'application/json' } }
        )
    },
    getMoyennes(context, params) {
      let nameUrl = "moyennes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('moyennes', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getMoyennesMatieres(context, params) {
      let nameUrl = "moyennes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('moyennesmatieres', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getMoyennesSections(context, params) {
      let nameUrl = "moyennes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('moyennessections', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getRaisonsAbsences(context, params) {
      let nameUrl = "raisonsabsences"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('raisonsabsences', response.data.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getMoyenneAnnuelle(context, params) {
      let nameUrl = "moyennes"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          if(response.data.data){
            context.commit('moyenneannuelle', response.data.data[0])
          }
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllLogSms(context, params) {
      let nameUrl = "logsms"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('alllogsms', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getLogSms(context, params) {
      getInformModel(context, params.logSmsId, "logsms", "logsms")
    },
    getAbonnements(context, params) {
      let nameUrl = "abonnements"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('abonnements', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('currentPage', response.data.data.current_page);
          context.commit('countPage', response.data.data.last_page);
          context.commit('totalElement', response.data.data.total);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAbonnement(context, params) {
      getInformModel(context, params.abonnementId, "abonnements", "abonnement")
    },
    getRaisonAbsence(context, params) {
      getInformModel(context, params.raisonabsenceId, "raisonsabsences", "raisonabsence")
    },
    saveAbonnementWithEleves(context, params) {
      return Axios.post(
        context.state.endpoint + 'api/v1/abonnements/store-with-eleves', params.data,
        { headers: { 'Content-Type': 'application/json' } }
      )
    },
    updateAbonnementWithEleves(context, params){
      return Axios.put(
        context.state.endpoint + 'api/v1/abonnements/update-with-eleves/'+params.id, params.data,
        { headers: { 'Content-Type': 'application/json' }  }
      )
    },
    updateSchoolCustomise(context, params){
      return Axios.put(
        context.state.endpoint + 'api/v1/schools/customise-school/'+params.id, params.data,
        { headers: { 'Content-Type': 'application/json' }  }
      )
    },
    getAllPacksAbonnement(context, params) {
      let nameUrl = "packsabonnements"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('packsabonnement', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllElevesAbonnement(context, params) {
        Axios.get(
        context.state.endpoint + 'api/v1/abonnements/abonnements-eleves/' + params.abonnementId
      )
        .then(response => {
          context.commit("elevesabonnement", response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    chooseEleve(context, chooseEleve){
      context.commit('chooseEleve', chooseEleve)
    },
    classeByProfesseur(context, classeByProfesseurId) {
      Axios.get(
        context.state.endpoint + 'api/v1/professeursclasses/' + classeByProfesseurId
      )
        .then(response => {
          context.commit('classeByProfesseur', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    note(context, noteId) {
      Axios.get(
        context.state.endpoint + 'api/v1/notemodel/' + noteId
      )
        .then(response => {
          context.commit('note', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    noteeleve(context, noteEleveId) {
      Axios.get(
        context.state.endpoint + 'api/v1/noteseleves/' + noteEleveId
      )
        .then(response => {
          context.commit('noteeleve', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    deleteNote(context, noteId) {
      return Axios.get(
        context.state.endpoint + 'api/v1/notemodel/' + noteId + '/delete'
      );
    },
    deleteAbsenceEleve(context, absenceId) {
      return Axios.get(
        context.state.endpoint + 'api/v1/absenceseleves/' + absenceId + '/delete'
      );
    },/*
    getElevesByClasseId(context, params) {
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
        // concatParams = '&' + concatParams
      }
      // console.log("liste des parametres "+JSON.stringify(params.payload));
      let url = null;
      if(concatParams){
        url = context.state.endpoint + 'api/v1/elevesclasses?page=' + params.payload + '&' + concatParams;
      }else{
        url = context.state.endpoint + 'api/v1/elevesclasses?page=' + params.payload;
      }
      Axios.get(
        url)
        .then(response => {
          context.commit('eleves', response.data.data.data)
          // console.log("eleves "+ JSON.stringify(response.data.data.data))
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },*/
    eleve(context, eleveId) {
      Axios.get(
        context.state.endpoint + 'api/v1/eleves/'+eleveId)
        .then(response => {
          context.commit('eleve', response.data.data)
          // console.log("eleve "+ JSON.stringify(response.data.data))
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    professeur(context, professeurId) {
      // console.log("le professeur id est "+ professeurId)
      Axios.get(
        context.state.endpoint + 'api/v1/professeurs/'+professeurId)
        .then(response => {
          context.commit('professeur', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getClassesByProfesseurId(context, professeurId){
      Axios.get(
        context.state.endpoint + 'api/v1/classes-by-professeur-id/'+professeurId)
        .then(response => {
          context.commit('classes', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    updateUser(context, data) {
        return Axios.post(
          context.state.endpoint + 'api/v1/users/update', data,
          { headers: { 'Content-Type': 'application/json' } }
        )
    },
    classeId(context, classeId){
      context.commit('classeId', classeId)
    },
    sectionAnneeScolaireId(context, sectionAnneeScolaireId){
      context.commit('sectionAnneeScolaireId', sectionAnneeScolaireId)
    },
    anneeScolaireId(context, anneeScolaireId){
      context.commit('anneeScolaireId', anneeScolaireId)
    },
    classeprofesseurmatiere(context, params) {
      let concatParams = null
      if (params) {
        concatParams = params.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
      }
      let url = null;
      if(concatParams){
        url = context.state.endpoint + 'api/v1/classesprofesseursmatieres?' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/classesprofesseursmatieres/'
      }
      Axios.get(
        url
      )
        .then(response => {
          context.commit('classes', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    classesprofesseursmatieres(context, params) {
      let concatParams = null
      if (params) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
      }
      let url = null;
      if(concatParams){
        url = context.state.endpoint + 'api/v1/classesprofesseursmatieres?' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/classesprofesseursmatieres/'
      }
      Axios.get(
        url
      )
        .then(response => {
          context.commit('classesprofesseursmatieres', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    sectionsanneescolaire(context, params) {
      let concatParams = null
      if (params) {
        concatParams = params.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
      }
      let url = null;
      if(concatParams){
        url = context.state.endpoint + 'api/v1/sectionsanneescolaire?' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/sectionsanneescolaire/'
      }
      Axios.get(
        url
      )
        .then(response => {
          context.commit('sectionsanneescolaire', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    saveSessionUserApp(context, data) {
      let url = null;
        // console.log("liste des params "+JSON.stringify(data));
      if(data.id){
        return Axios.put(context.state.endpoint + 'api/v1/sessionsuserapp/'+data.id, data.data,
        { headers: { 'Content-Type': 'application/json' } })
      }else{
        return Axios.post(context.state.endpoint + 'api/v1/sessionsuserapp', data.data,
        { headers: { 'Content-Type': 'application/json' } })
      }
    },
    searchMatiereByClasseAndProfesseur(context, params) {
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&');
      }
      Axios.get(
        context.state.endpoint + 'api/v1/search-matiere-by-classe-and-professeur?' + concatParams
      )
        .then(response => {
          context.commit('matiere', response.data.data);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    login(context, payload) {
      const data = new FormData()
      data.append('email', payload.email)
      data.append('password', payload.password)
      return Axios.post(
        context.state.endpoint + 'api/v1/users/login-backend', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    generateBilanAndSend(context, params){
      Axios.get(
        context.state.endpoint + 'api/v1/eleves/rapport/'+params.sectionAnneeScolaireId
      )
        .then(response => {
          alert("Le bilan a été généré a été envoyé")
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    generateBilanPeriodique(context, params){
      Axios.get(
        context.state.endpoint + 'api/v1/moyennes/send-billan-periodique/'+params.sectionAnneeScolaireId
      )
        .then(response => {
          alert("Le bilan périodique a été envoyé ");
          window.location.reload();
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getAllPays(context, params) {
      let nameUrl = "pays"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('pays', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getParametrageApp(context, params) {
      getInformModel(context, params.parametrageappId, "parametrages", "parametrageapp")
    },
    sendTestSms(context, params) {
      Axios.get(
        context.state.endpoint + 'api/v1/test-sms-v1?tel=' + params.tel + '&message=' + params.message
      )
        .then(response => {
          alert("sms sent successfully !")
          window.location.reload();
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    generateNotesForSection(context, params) {
      Axios.get(
        context.state.endpoint + 'api/v1/generate-data-for-section-annee-scolaire/' + params.sectionAnneeScolaireId
      )
        .then(response => {
          alert("Data notes generated successfuly !")
          window.location.reload();
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getTypesMoyennes(context, params) {
      let nameUrl = "typesmoyenne"
      let url = getUrl(context, nameUrl, params)
      Axios.get(url)
        .then(response => {
          context.commit('typesmoyennes', response.data.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getTypeMoyenne(context, params) {
      getInformModel(context, params.id, "typesmoyenne", "typemoyenne")
    },
    ecolesms(context, ecoleId) {
      Axios.get(
        context.state.endpoint + 'api/v1/ecolesms?school_id='+ecoleId)
        .then(response => {
          if(response.data.data.data && response.data.data.data.length > 0){
            context.commit('ecolesms', response.data.data.data[0])
          }
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    updateStatutSms(context, params) {
      return Axios.put(
        context.state.endpoint + 'api/v1/ecolesms/'+params.id, params.data,
        { headers: { 'Content-Type': 'application/json' } }
      )
    },
    getEleveClasseByEleveIdAndAnneeScolaireId(context, param){
      // eleveclass
      Axios.get(
        context.state.endpoint + 'api/v1/get-eleveclasse/'+param.eleveId+'/'+param.AnneeScolaireId)
        .then(response => {
          if(response.data.data.data && response.data.data.data.length > 0){
            // context.commit('eleveclass', response.data.data.data[0])
            console.log("get-eleves-classes -> "+response.data.data);
          }
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getSchool(context, params) {
      Axios.get(
        context.state.endpoint + 'api/v1/schools/show-customise/' + params.schoolId
      )
        .then(response => {
          context.commit("school", response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    }
  }
  
  // modules: modules
})
