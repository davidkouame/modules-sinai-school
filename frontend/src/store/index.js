import Vue from 'vue'
import Vuex from 'vuex'
import Axios from "axios";

Vue.use(Vuex)

export default new Vuex.Store({
    strict: true,
    state: {
        endpoint: 'http://localhost/modules-sinai-school/backend/',
        api: 'api/v1/note/',
        notes: [],
        noteseleves: [],
        pageCount: 1,
        userId: 1
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
                    console.log("la valeur de pageCount dans l'actions est " + response.data.data.last_page)
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },
        allnoteseleves(context, payload) {
            Axios.get(
                context.state.endpoint + "api/v1/noteeleve?eleve_id=" + payload.userId + "&page=" + payload.pageNum
            )
                .then(response => {
                    context.commit('noteseleves', response.data.data.data)
                    context.commit('pageCount', response.data.data.last_page)
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
        }
    }
})