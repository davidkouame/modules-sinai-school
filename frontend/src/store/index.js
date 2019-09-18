import Vue from 'vue'
import Vuex from 'vuex'
import Axios from "axios";

Vue.use(Vuex)

export default new Vuex.Store({
    strict: true,
    state: {
        // endpoint: 'http://localhost/modules-sinai-school/backend/',
        endpoint: 'http://localhost/modules-sinai-school/backend/',
        api: 'api/v1/note/',
        notes: [],
        noteseleves: [],
        pageCount: 1,
        userId: 6,
        classe: null,
        absenceseleves: [],
        absenceeleve: null,
        eleves: [],
        raisonsabsences: []
        // userId: 1
    },
    mutations: {
        notes(state, payload) {
            state.notes = payload
        },
        noteseleves(state, payload) {
            state.noteseleves = payload
        },
        pageCount(state, payload) {
            state.pageCount = payload
        },
        classe(state, classe){
            state.classe = classe
        },
        absenceseleves(state, absenceseleves){
            state.absenceseleves = absenceseleves
        },
        absenceeleve(state, absenceeleve){
            state.absenceeleve = absenceeleve
        },
        eleves(state, eleves){
            state.eleves = eleves
        },
        raisonsabsences(state, raisonsabsences){
            state.raisonsabsences = raisonsabsences
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
        }
    },
    actions: {
        allnotes(context, payload = 1) {
            Axios.get(
                context.state.endpoint + "api/v1/note?page=" + payload
            )
                .then(response => {
                    context.commit('notes', response.data.data.data)
                    context.commit('pageCount', response.data.data.last_page)
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        allnoteseleves(context, payload) {
            Axios.get(
                context.state.endpoint + "api/v1/noteseleves?eleve_id=" + payload.userId + "&page=" + payload.pageNum
            )
                .then(response => {
                    context.commit('noteseleves', response.data.data.data)
                    context.commit('pageCount', response.data.data.last_page)
                    // console.log("log pageCount "+JSON.stringify(response.data.last_page))
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        loginParentEleve(context, payload) {
            const data = new FormData();
            data.append('email', payload.email);
            data.append('password', payload.password);
            return Axios.post(
                context.state.endpoint + "api/v1/users/login", data,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            );
        },
        login(context, payload) {
            const data = new FormData();
            data.append('email', payload.email);
            data.append('password', payload.password);
            return Axios.post(
                context.state.endpoint + "api/v1/users/login", data,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            );
        },
        classe(context, eleveId){
            Axios.get(
                context.state.endpoint + "api/v1/classes/" + 9
            )
                .then(response => {
                    context.commit('classe', response.data.data)
                    // console.log(response.data.data);
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        absenceseleves(context, request){
            let axios = null;
            if(request.eleveId){
                axios = Axios.get(
                    context.state.endpoint + "api/v1/absenceseleves?eleve_id=" + request.eleveId + "&page=" + request.pageNum
                );
            }else{
                axios = Axios.get(
                    context.state.endpoint + "api/v1/absenceseleves?page=" + request.pageNum
                );
            }
            axios.then(response => {
                    context.commit('absenceseleves', response.data.data.data)
                    context.commit('pageCount', response.data.data.last_page)
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        absenceeleve(context, request){
            Axios.get(
                context.state.endpoint + "api/v1/absenceseleves/" + request.absenceEleveId
            )
                .then(response => {
                    // console.log("log absence eleve"+JSON.stringify(response.data.data));
                    context.commit('absenceeleve', response.data.data)
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        eleves(context) {
            Axios.get(
                context.state.endpoint + "api/v1/eleves"
            )
                .then(response => {
                    context.commit('eleves', response.data.data)
                    // console.log("log d'eleves dans le store "+ response.data.data);
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        raisonsabsences(context) {
            Axios.get(
                context.state.endpoint + "api/v1/raisonsabsences"
            )
                .then(response => {
                    context.commit('raisonsabsences', response.data.data)
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        saveAgence(context, data){
            return Axios.post(
                context.state.endpoint + "api/v1/absenceseleves", data,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            ); 
        }
    }
})