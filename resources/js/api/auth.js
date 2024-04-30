import api from "./api";

export default {
    register(form){
        return api.get("/sanctum/csrf-cookie").then(()=>
            api.post("/auth/register", form)
        )
    },
    login(form){
        return api.get("/sanctum/csrf-cookie").then(()=>
            api.post("/auth/login", form)
        )
    },
    logout(){
        return api.get("/sanctum/csrf-cookie").then(()=>
            api.post("/auth/logout")
        )
    },
    verifyUserByEmail(email){
        return api.get(`/auth/verifyUserByEmail/${email}`);
    },
}
