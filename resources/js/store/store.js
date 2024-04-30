import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

const store = new Vuex.Store({
    plugins: [createPersistedState()],
    state: {
        user: null,
        selectedDate: new Date().toISOString().slice(0,10),
    },
    getters: {
        getSelectedDate(state){
            return state.selectedDate;
        },
    },
    mutations : {
        setUser(state, payload){
            state.user = payload
        },
        setSelectedDate(state, payload){
            state.selectedDate = payload
        },
    },
})

export default store
