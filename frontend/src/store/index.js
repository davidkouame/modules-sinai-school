import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'
import storeParent from '@/components/pages/parents/store'
import storeEleve from '@/components/pages/eleves/store'

Vue.use(Vuex)

let modules = null
if (localStorage.getItem('userId')) {
  if (localStorage.getItem('userType') == "parent") {
    modules = { storeParent }
  }else if (localStorage.getItem('userType') == "eleve"){
    modules = { storeEleve }
  }
} 
export default new Vuex.Store({
  modules: modules,
  strict: true,
  state: {
    // endpoint: 'http://localhost/modules-sinai-school/backend/',
    endpoint: 'http://localhost/modules-sinai-school/backend/',
    api: 'api/v1/note/',
    notes: [],
    noteseleves: [],
    note: null,
    pageCount: 1,
    pageCountNote: 1,
    userId: 6,
    classe: null,
    absenceseleves: [],
    absenceeleve: null,
    eleves: [],
    eleve: null,
    raisonsabsences: [],
    absenceeleve: null,
    typesnotes: [],
    matieres: [],
    classes: [],
    classesByProfesseur: [],
    classeByProfesseur: [],
    professeur: null,
    classeId: null,
    classeprofesseurmatiere: null,
    classesprofesseursmatieres: null
  },
  mutations: {
    notes(state, payload) {
      state.notes = payload
    },
    noteseleves(state, payload) {
      state.noteseleves = payload
    },
    note(state, note) {
      state.note = note
    },
    pageCount(state, payload) {
      state.pageCount = payload
    },
    pageCountNote(state, payload) {
      state.pageCountNote = payload
    },
    classe(state, classe) {
      state.classe = classe
    },
    absenceseleves(state, absenceseleves) {
      state.absenceseleves = absenceseleves
    },
    absenceeleve(state, absenceeleve) {
      state.absenceeleve = absenceeleve
    },
    eleves(state, eleves) {
      state.eleves = eleves
    },
    raisonsabsences(state, raisonsabsences) {
      state.raisonsabsences = raisonsabsences
    },
    absenceeleve(state, absenceeleve) {
      state.absenceeleve = absenceeleve
    },
    typesnotes(state, typesnotes) {
      state.typesnotes = typesnotes
    },
    matieres(state, matieres) {
      state.matieres = matieres
    },
    classes(state, classes) {
      state.classes = classes
    },
    classesByProfesseur(state, classesByProfesseur) {
      state.classesByProfesseur = classesByProfesseur
    },
    classeByProfesseur(state, classeByProfesseur) {
      state.classeByProfesseur = classeByProfesseur
    },
    eleve(state, eleve) {
      state.eleve = eleve
    },
    professeur(state, professeur) {
      state.professeur = professeur
    },
    classeId(state, classeId) {
      state.classeId = classeId
    },
    classeprofesseurmatiere(state, classeprofesseurmatiere){
      state.classeprofesseurmatiere = classeprofesseurmatiere
    },
    classesprofesseursmatieres(state, classesprofesseursmatieres){
      state.classesprofesseursmatieres = classesprofesseursmatieres
    }
  },
  getters: {
    notes: state => {
      return state.notes
    },
    noteseleves: state => {
      return state.noteseleves
    },
    pageCount: state => {
      return state.pageCount
    },
    pageCountNote: state => {
      return state.pageCountNote
    },
    userId: state => {
      return state.userId
    },
    classe: state => {
      return state.classe
    },
    absenceseleves: state => {
      return state.absenceseleves
    },
    absenceeleve: state => {
      return state.absenceeleve
    },
    eleves: state => {
      return state.eleves
    },
    eleve: state => {
      return state.eleve
    },
    raisonsabsences: state => {
      return state.raisonsabsences
    },
    absenceeleve: state => {
      return state.absenceeleve
    },
    typesnotes: state => {
      return state.typesnotes
    },
    matieres: state => {
      return state.matieres
    },
    classes: state => {
      return state.classes
    },
    classesByProfesseur: state => {
      return state.classesByProfesseur
    },
    classeByProfesseur: state => {
      return state.classeByProfesseur
    },
    note: state => {
      return state.note
    },
    professeur: state => {
      return state.professeur
    },
    classeId: state => {
      return state.classeId
    },
    classeprofesseurmatiere: state => {
      return state.classeprofesseurmatiere
    },
    classesprofesseursmatieres: state => {
      return state.classesprofesseursmatieres
    }
  },
  actions: {
    allnotes(context, params) {
      // console.log("all notes "+JSON.stringify(params));
      let concatParams = null
      if (params.search) {
        // console.log("params "+ JSON.stringify(params.search))
        concatParams = params.search.map(function (elemen) {
          // console.log("element ===> "+ elemen.key)
          return elemen.key + '=' + elemen.value
        }).join('&')
        // concatParams = '&' + concatParams
      }
      // console.log("resultat de la recherche exemplejoin "+concatParams);
      let url = null
        // concatParams = '&' + concatParams
      if(concatParams){
        // console.log("concatParams => "+concatParams)
        url = context.state.endpoint + 'api/v1/notemodel?page=' + params.payload + '&' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/notemodel?page=' + params.payload
      }
      Axios.get(url)
        .then(response => {
          context.commit('notes', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          context.commit('pageCountNote', response.data.data.last_page)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    allnoteseleves(context, payload) {
      Axios.get(
        context.state.endpoint + 'api/v1/noteseleves?eleve_id=' + payload.userId + '&page=' + payload.pageNum
      )
        .then(response => {
          context.commit('noteseleves', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
          // console.log("log pageCount "+JSON.stringify(response.data.last_page))
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    loginParentEleve(context, payload) {
      const data = new FormData()
      data.append('email', payload.email)
      data.append('password', payload.password)
      return Axios.post(
        context.state.endpoint + 'api/v1/users/login', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    login(context, payload) {
      const data = new FormData()
      data.append('email', payload.email)
      data.append('password', payload.password)
      return Axios.post(
        context.state.endpoint + 'api/v1/users/login', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    classe(context, eleveId) {
      Axios.get(
        context.state.endpoint + 'api/v1/classes/' + 9
      )
        .then(response => {
          context.commit('classe', response.data.data)
          // console.log(response.data.data);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    absenceselevesprofesseur(context, params) {
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
        concatParams = '&' + concatParams
      }
      let axios = null
      if (params.eleveId) {
        axios = Axios.get(
          context.state.endpoint + 'api/v1/absenceseleves?eleve_id=' + params.eleveId + '&page=' + params.pageNum
        )
      } else {
        if(concatParams){
          // console.log("concatParams est n'est pas null");
          axios = Axios.get(context.state.endpoint + 'api/v1/absenceseleves?page=' + params.payload + concatParams)
        }else{
          // console.log("concatParams est null");
          axios = Axios.get(context.state.endpoint + 'api/v1/absenceseleves?page=' + params.payload)
        }
        // console.log("seconde parametre est "+ concatParams.length);
      }
      axios.then(response => {
        context.commit('absenceseleves', response.data.data.data)
        context.commit('pageCount', response.data.data.last_page)
        // console.log("absence eleves ====> "+ response.data.data.data)
      })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    }/*,
    absenceseleves (context, request) {
      let axios = null
      if (request.eleveId) {
        axios = Axios.get(
          context.state.endpoint + 'api/v1/absenceseleves?eleve_id=' + request.eleveId + '&page=' + request.pageNum
        )
      } else {
        axios = Axios.get(
          context.state.endpoint + 'api/v1/absenceseleves?page=' + request.pageNum
        )
      }
      axios.then(response => {
        context.commit('absenceseleves', response.data.data.data)
        context.commit('pageCount', response.data.data.last_page)
      })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    }*/,
    absenceeleve(context, request) {
      Axios.get(
        context.state.endpoint + 'api/v1/absenceseleves/' + request.absenceEleveId
      )
        .then(response => {
          // console.log("log absence eleve"+JSON.stringify(response.data.data));
          context.commit('absenceeleve', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    eleves(context) {
      Axios.get(
        context.state.endpoint + 'api/v1/eleves'
      )
        .then(response => {
          context.commit('eleves', response.data.data)
          // console.log("log d'eleves dans le store "+ response.data.data);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    raisonsabsences(context) {
      Axios.get(
        context.state.endpoint + 'api/v1/raisonsabsences'
      )
        .then(response => {
          context.commit('raisonsabsences', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    saveAgence(context, data) {
      return Axios.post(
        context.state.endpoint + 'api/v1/absenceseleves', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    absenceseleves(context, data) {
      // console.log("information data "+JSON.stringify(data.))
      // console.log("information data "+data.params.eleveId);
      if (data && data.action == 'edit') {
        return Axios.put(
          context.state.endpoint + 'api/v1/absenceseleves/' + data.absenceEleveId, data.data,
          { headers: { 'Content-Type': 'json' } }
        )
      } else {
        let axios = null
        if (data.eleveId) {
          axios = Axios.get(context.state.endpoint + 'api/v1/absenceseleves?eleve_id=' + data.eleveId + '&page=' + data.payload)
        } else {
          axios = Axios.get(context.state.endpoint + 'api/v1/absenceseleves?page=' + data.payload)
        }
        axios.then(response => {
          context.commit('absenceseleves', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
      }
    },
    typesnotes(context) {
      Axios.get(
        context.state.endpoint + 'api/v1/typesnotes'
      )
        .then(response => {
          context.commit('typesnotes', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    matieres(context) {
      Axios.get(
        context.state.endpoint + 'api/v1/matieres'
      )
        .then(response => {
          context.commit('matieres', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    saveNote(context, data) {
      if (data.id) {
        return Axios.put(
          context.state.endpoint + 'api/v1/notemodel/' + data.id, data,
          { headers: { 'Content-Type': 'application/json' } }
        )
      } else {
        return Axios.post(
          context.state.endpoint + 'api/v1/notemodel', data,
          { headers: { 'Content-Type': 'application/json' } }
        )
      }
    },
    classes(context, params) {
      let concatParams = null
      if (params) {
        concatParams = params.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
        // concatParams =  concatParams
      }
      console.log("params "+ JSON.stringify(concatParams))
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
          // console.log("liste de toutes les classes "+JSON.stringify(response.data.data));
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    classesByProfesseur(context, professeurId) {
      Axios.get(
        context.state.endpoint + 'api/v1/professeursclasses?professeur_id=' + professeurId
      )
        .then(response => {
          context.commit('classesByProfesseur', response.data.data)
          // console.log("liste de toutes les classes "+JSON.stringify(response.data.data));
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
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
    deleteNote(context, noteId) {
      return Axios.get(
        context.state.endpoint + 'api/v1/notemodel/' + noteId + '/delete'
      );
    },
    deleteAbsenceEleve(context, absenceId) {
      return Axios.get(
        context.state.endpoint + 'api/v1/absenceseleves/' + absenceId + '/delete'
      );
    },
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
    },
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
    }
  }
})
