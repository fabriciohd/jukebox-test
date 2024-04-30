import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/store'


Vue.use(VueRouter)

const routes = [{
        path: "/",
        meta: {
            requiresAuth: true
        },
        component: () => import('@templates/default/Index'),
        children: [
            {
                path: '',
                name: 'Home',
                meta: {
                    title: "Início",
                },
                component: () => import('@pages/Home/Home')
            },
        ]
    },

    {
        path: "/login",
        name: "Login",
        meta: {
            title: "Login",
        },
        component: () => import('@pages/Auth/Login'),
        //meta: {guest: true},
    },
]


const router = new VueRouter({
    mode: "history",
    routes
})

function loggedIn() {
    return !!store.state.user;
}


const DEFAULT_TITLE = 'Tasks';
router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = 'Tasks - ' + to.meta.title || DEFAULT_TITLE;
    });
})

router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!loggedIn()) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (loggedIn()) {
            next({
                path: '/',
                query: {
                    redirect: to.fullPath
                }
            })
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
})

export default router
