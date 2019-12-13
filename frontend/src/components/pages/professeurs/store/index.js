import Axios from 'axios'

export default {
  strict: true,
  state: {
    api: 'api/v1/note/',
    notes: [],
    noteseleves: [],
    note: null,
    pageCount: 1,
    pageCountSection: 1,
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
    eleveId: null,
    matiere: null,
    parent: null,
    moyennes: null,
    moyennesSections: null,
    moyenne: null,
    valeurs: null,
    rapportvalidation: null,
    endpoint: 'http://localhost:8888/modules-sinai-school/backend/',
    // endpoint: 'http://monsitenet.com/modules-sinai-school/backend/'
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
    pageCountSection(state, pageCountSection) {
      state.pageCountSection = pageCountSection
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
    eleveId(state, eleveId) {
      state.eleveId = eleveId
    },
    matiere(state, matiere){
      state.matiere = matiere
    },
    parent(state, parent){
      state.parent = parent
    },
    moyennes(state, moyennes){
      state.moyennes = moyennes
    },
    moyennesSections(state, moyennesSections){
      state.moyennesSections = moyennesSections
    },
    moyenne(state, moyenne){
      state.moyenne = moyenne
    },
    valeurs(state, valeurs){
      state.valeurs = valeurs
    },
    rapportvalidation(state, rapportvalidation){
      state.rapportvalidation = rapportvalidation
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
    pageCountSection: state => {
      return state.pageCountSection
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
    eleveId: state => {
      return state.eleveId
    },
    matiere: state => {
      return state.matiere
    },
    parent: state => {
      return state.parent
    },
    moyennes: state => {
      return state.moyennes
    },
    moyennesSections: state => {
      return state.moyennesSections
    },
    moyenne: state => {
      return state.moyenne
    },
    valeurs: state => {
      return state.valeurs
    },
    rapportvalidation: state => {
      return state.rapportvalidation
    }
  },
  actions: {
    allnotes(context, params) {
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
      }
      let url = null
      if(concatParams){
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
    allnotesandvaleur(context, params) {
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
      }
      let url = null
      if(concatParams){
        url = context.state.endpoint + 'api/v1/notemodel-valeur?page=' + params.payload + '&' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/notemodel-valeur?page=' + params.payload
      }
      Axios.get(url)
        .then(response => {
          context.commit('notes', response.data.data.notes.data)
          context.commit('pageCount', response.data.data.notes.last_page)
          context.commit('pageCountNote', response.data.data.notes.last_page)
          context.commit('valeurs', response.data.data.valeurs)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    allnotesparent(context, params) {
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
          return elemen.key + '=' + elemen.value
        }).join('&')
      }
      let url = null
      if(concatParams){
        url = context.state.endpoint + 'api/v1/get-notes?page=' + params.payload + '&' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/get-notes?page=' + params.payload
      }
      Axios.get(url)
        .then(response => {
          // console.log("chargement des notes "+JSON.stringify(response.data.data.data));
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
    elevesProfesseur(context) {
      Axios.get(
        context.state.endpoint + 'api/v1/eleves'
      )
        .then(response => {
          context.commit('eleves', response.data.data.data)
          // console.log("log d'eleves dans le store "+ response.data.data);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    loadElevesByProfesseurId(context, parent_id) {
      Axios.get(
        context.state.endpoint + 'api/v1/eleves?parent_id='+parent_id
      )
        .then(response => {
          context.commit('eleves', response.data.data.data)
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
    saveRapport(context, data) {
      return Axios.post(
        context.state.endpoint + 'api/v1/rapportsvalidations', data,
        { headers: { 'Content-Type': 'application/json' } }
      )
      /*const data1 = new FormData()
      data1.append('email', "payloademail")
      data1.append('password', "payload.password")
      return Axios.post(
        context.state.endpoint + 'api/v1/rapportsvalidations', data1,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )*/
    },
    /*absenceselevesP(context, data) {
      // console.log("information data "+JSON.stringify(data.))
      // console.log("information data "+data.params.eleveId);
      if (data && data.action == 'edit') {
        // console.log("dsdssd");
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
    },*/
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
          context.commit('matieres', response.data.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    matieresall(context) {
      Axios.get(
        context.state.endpoint + 'api/v1/matieres-all'
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
    saveNoteP(context, data) {
       // console.log("@@@@@@@ "+ JSON.stringify(data));
      if (data.id) {
        return Axios.put(
          context.state.endpoint + 'api/v1/notemodel/' + data.id, data,
          { headers: { 'Content-Type': 'application/json' } }
        )
      } else {
        console.log("liste des parametres "+JSON.stringify(data));
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
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    moyennes(context, params) {
     // console.log("@@@@@@@@@@@@@@@@@@@@@");
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
            return elemen.key + '=' + elemen.value
        }).join('&');
      }
      let url = null;
      if(concatParams){
        url = context.state.endpoint + 'api/v1/moyennes?' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/moyennes/'
      }
      Axios.get(
        url
      )
        .then(response => {
          context.commit('moyennes', response.data.data.data);
          context.commit('pageCount', response.data.data.last_page);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    moyennesX(context, params) {
           
      let concatParams = null
      if (params.search) {
        concatParams = params.search.map(function (elemen) {
            return elemen.key + '=' + elemen.value
        }).join('&');
      }
      let url = null;
      if(concatParams){
        url = context.state.endpoint + 'api/v1/moyennes?' + concatParams
      }else{
        url = context.state.endpoint + 'api/v1/moyennes/'
      }
       console.log("&&&&&&&&&&&&&&&&&&&&");
      Axios.get(
        url
      )
        .then(response => {
              console.log(">>>>>>>>>>>>>>>>>> "+JSON.stringify(response.data.data.data));
          context.commit('moyennesSections', response.data.data.data);
          context.commit('pageCountSection', response.data.data.last_page);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    classesByProfesseur(context, professeurId) {
      console.log("nous sommes dans la fonction classesByProfesseur et le context state est "+ JSON.stringify(context.state));
      /*Axios.get(
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
        .finally(() => (this.loading = false))*/
        Axios.get(
        context.state.endpoint + 'api/v1/allprofesseursclassesbyuniqueclasse?professeur_id=' + professeurId
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
    noteparent(context, noteId) {
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
          context.commit('pageCount', response.data.data.last_page)
          // console.log("eleves "+ JSON.stringify(response.data.data.data))
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    eleveP(context, eleveId) {
      Axios.get(
        context.state.endpoint + 'api/v1/eleves/'+eleveId)
        .then(response => {
          context.commit('eleve', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    professeurP(context, professeurId) {
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
    getClassesByProfesseurIdP(context, professeurId){
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
    }/*,
    updateUser(context, data) {
        return Axios.post(
          context.state.endpoint + 'api/v1/users/update', data,
          { headers: { 'Content-Type': 'application/json' } }
        )
    }*/,
    classeId(context, classeId){
      context.commit('classeId', classeId)
    },
    eleveId(context, eleveId){
      context.commit('eleveId', eleveId)
    },
    matiere(context, matiereId) {
      Axios.get(
        context.state.endpoint + 'api/v1/matieres/' + matiereId
      )
        .then(response => {
          context.commit('matiere', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    parent(context, parentId) {
      Axios.get(
        context.state.endpoint + 'api/v1/parents/'+parentId)
        .then(response => {
          context.commit('parent', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    absenceselevesP(context, data) {
      if (data && data.action == 'edit') {
        return Axios.put(
          context.state.endpoint + 'api/v1/absenceseleves/' + data.absenceEleveId, data.data,
          { headers: { 'Content-Type': 'json' } }
        )
      } else {
          // console.log("data is "+JSON.stringify(data));
        let concatParams = null
        if (data.search) {
          concatParams = data.search.map(function (elemen) {
            return elemen.key + '=' + elemen.value
          }).join('&')
        }

        if (data.eleveId) {
          if(concatParams){
            concatParams = 'eleve_id=' + data.eleveId  + '&' + concatParams
          }else{
            concatParams = 'eleve_id=' + data.eleveId
          }
        }

        let url = null;
        if(concatParams){
          url = context.state.endpoint + 'api/v1/absenceseleves?page=' + data.pageNum + '&' + concatParams;
        }else{
          url = context.state.endpoint + 'api/v1/absenceseleves?page=' + data.pageNum;
        }

        Axios.get(url)
        .then(response => {
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
    getMoyenneMatiere(context, params) {
      Axios.get(
        context.state.endpoint + 'api/v1/moyenne-matiere?eleve_id='+
        params.eleveId+'&matiere_id='+params.matiereId)
        .then(response => {
          context.commit('moyenne', response.data.data);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getMatiereByProfesseurAndClasse(context, params){
       Axios.get(
        context.state.endpoint + 'api/v1/get-matiere-by-professeur-and-classe/'
        +params.professeurId+'/'+params.classeId)
        .then(response => {
          context.commit('matiere', response.data.data);
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false)) 
    },
    moyenne(context, moyenneId) {
      Axios.get(
        context.state.endpoint + 'api/v1/moyennes/' + moyenneId
      )
        .then(response => {
          context.commit('moyenne', response.data.data)
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
    getValeurNote(context, params) {
      return Axios.get(
        context.state.endpoint + 'api/v1/get-valeur-by-eleve_id-and-note_id/' + 
        params.eleveId + '/' + params.noteId
      )
    },
    saveNoteEleve(context, data) {
      if (data.id) {
        return Axios.put(
          context.state.endpoint + 'api/v1/noteseleves/' + data.id, data,
          { headers: { 'Content-Type': 'application/json' } }
        )
      } else {
        return Axios.post(
          context.state.endpoint + 'api/v1/noteseleves', data,
          { headers: { 'Content-Type': 'application/json' } }
        )
      }
    },
    addValueNote(context, data) {
        return Axios.put(
          context.state.endpoint + 'api/v1/noteseleves-valeur/' + data.eleve_id
             + '/' + data.note_id, data,
          { headers: { 'Content-Type': 'application/json' } }
        )
    },
    getRapportValidationByClasseId(context, classeId) {
      Axios.get(
        context.state.endpoint + 'api/v1/rapportsvalidations?classe_id=' +classeId 
      )
        .then(response => {
            if(response.data.data){
                context.commit('rapportvalidation', response.data.data[0])
            }else{
                context.commit('rapportvalidation', null)
            }
        })
        .catch(error => {
          console.log(error)
          this.errored = true
        })
        .finally(() => (this.loading = false))
    },
  }
}
