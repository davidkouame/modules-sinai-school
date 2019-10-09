import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: true,
  state: {
    // endpoint: 'http://localhost/modules-sinai-school/backend/',
    endpoint: 'http://localhost/modules-sinai-school/backend/',
    api: 'api/v1/note/',
    notes: [],
    noteseleves: [],
    note: null,
    pageCount: 1,
    userId: 6,
    classe: null,
    absenceseleves: [],
    absenceeleve: null,
    eleves: [],
    raisonsabsences: [],
    absenceeleve: null,
    typesnotes: [],
    matieres: [],
    classes: [],
    classesByProfesseur: [],
    classeByProfesseur: []
    // userId: 1
  },
  mutations: {
    notes (state, payload) {
      state.notes = payload
    },
    noteseleves (state, payload) {
      state.noteseleves = payload
    },
    note (state, note) {
      state.note = note
    },
    pageCount (state, payload) {
      state.pageCount = payload
    },
    classe (state, classe) {
      state.classe = classe
    },
    absenceseleves (state, absenceseleves) {
      state.absenceseleves = absenceseleves
    },
    absenceeleve (state, absenceeleve) {
      state.absenceeleve = absenceeleve
    },
    eleves (state, eleves) {
      state.eleves = eleves
    },
    raisonsabsences (state, raisonsabsences) {
      state.raisonsabsences = raisonsabsences
    },
    absenceeleve (state, absenceeleve) {
      state.absenceeleve = absenceeleve
    },
    typesnotes (state, typesnotes) {
      state.typesnotes = typesnotes
    },
    matieres (state, matieres) {
        	state.matieres = matieres
    },
    classes (state, classes) {
      state.classes = classes
    },
    classesByProfesseur (state, classesByProfesseur) {
      state.classesByProfesseur = classesByProfesseur
    },
    classeByProfesseur (state, classeByProfesseur) {
      state.classeByProfesseur = classeByProfesseur
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
    }
  },
  actions: {
    allnotes (context, params) {
      // console.log("liste des parametres à rechercher "+params.payload);
      // console.log("liste des parametres à rechercher "+JSON.stringify(params.search));
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
        concatParams = '&' + concatParams
      }
      // console.log("resultat de la recherche exemplejoin "+concatParams);
      Axios.get(
        context.state.endpoint + 'api/v1/notemodel?page=' + params.payload + concatParams
      )
        .then(response => {
          context.commit('notes', response.data.data.data)
          context.commit('pageCount', response.data.data.last_page)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    allnoteseleves (context, payload) {
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
    loginParentEleve (context, payload) {
      const data = new FormData()
      data.append('email', payload.email)
      data.append('password', payload.password)
      return Axios.post(
        context.state.endpoint + 'api/v1/users/login', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    login (context, payload) {
      const data = new FormData()
      data.append('email', payload.email)
      data.append('password', payload.password)
      return Axios.post(
        context.state.endpoint + 'api/v1/users/login', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    classe (context, eleveId) {
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
    },
    absenceeleve (context, request) {
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
    eleves (context) {
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
    raisonsabsences (context) {
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
    saveAgence (context, data) {
      return Axios.post(
        context.state.endpoint + 'api/v1/absenceseleves', data,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
    },
    absenceseleves (context, data) {
      if (data && data.action == 'edit') {
        return Axios.put(
          context.state.endpoint + 'api/v1/absenceseleves/' + data.absenceEleveId, data.data,
          { headers: { 'Content-Type': 'json' } }
        )
      } else {
        let axios = null
        if (data.eleveId) {
          axios = Axios.get(
            context.state.endpoint + 'api/v1/absenceseleves?eleve_id=' + data.eleveId + '&page=' + data.pageNum
          )
        } else {
          axios = Axios.get(
            context.state.endpoint + 'api/v1/absenceseleves?page=' + data.pageNum
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
      }
    },
    typesnotes (context) {
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
    matieres (context) {
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
    saveNote (context, data) {
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
    classes (context, eleveId) {
      Axios.get(
        context.state.endpoint + 'api/v1/classes/'
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
    classesByProfesseur (context, professeurId) {
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
    classeByProfesseur (context, classeByProfesseurId) {
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
    note (context, noteId) {
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
    deleteNote (context, noteId) {
      return Axios.get(
          context.state.endpoint + 'api/v1/notemodel/' + noteId + '/delete'
      );
    }
  }
})
