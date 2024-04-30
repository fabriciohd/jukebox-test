import api from "./api";

export default {
    async list(options, search = ''){
        return api.get("/task", {params: options})
    },
    async get(id){
        return api.get(`/task/${id}`)
    },
    async insert(form){
        return api.post('/task', form)
    },
    async update(form, id){
        return api.post(`/task/${id}?_method=put`, form)
    },
    async delete(id){
        return api.delete(`/task/${id}`)
    },
}
