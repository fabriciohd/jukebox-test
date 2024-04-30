import axios from "axios"
import router from "../router/router";
import store from "../store/store"

let Api = axios.create({
    baseURL: process.env.MIX_APP_URL+"/api"
})

Api.defaults.withCredentials = true;

Api.interceptors.response.use(
    response => {
        return response
    },
    async error => {
        if (error.response.status === 401 && router.currentRoute.name !== 'Login') {
            await store.commit('user', null)
            router.push({name: 'Login'})
        }
        return Promise.reject(error)
    }
)

export default Api;
