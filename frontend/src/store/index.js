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
        pageCount: 1
    },
    mutations: {
        notes(state, payload) {
            state.notes = payload
        },
        pageCount(state, payload) {
            state.pageCount = payload
        }
    },
    getters: {
        notes: state => {
            return state.notes
        },
        pageCount: state => {
            return state.pageCount
        }
    },
    actions: {
        allnotes (context, payload = 1){
            Axios.get(
                context.state.endpoint + "api/v1/note?page=" + payload
            )
                .then(response => {
                    context.commit('notes', response.data.data.data)
                    context.commit('pageCount', response.data.data.last_page)
                    console.log("la valeur de pageCount dans l'actions est " +response.data.data.last_page)
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        }
    }
})