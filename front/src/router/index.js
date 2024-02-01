import {createRouter, createWebHistory} from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import DefaultLayout from "../components/DefaultLayout.vue";

import store from "../store/index.js";
import AuthLayout from "../components/AuthLayout.vue";
import AdminLayout from "../components/AdminLayout.vue";
import Statistics from "../views/Statistics.vue";
import Rent from "../views/Rent.vue";

const routes = [
    {
        path: "/", redirect: "dashboard", name: "Dashboard", component: DefaultLayout, meta: {isUser: true, requiresAuth: true},
        children: [
            {path: "/dashboard", name: "Dashboard", component: Dashboard, meta: {isUser: true, requiresAuth: true} },
            {path: "/rent", name: "Rent", component: Rent, meta: {isUser: true, requiresAuth: true} },
        ],
    },
    {
        path: "/admin", redirect: "statistics", name: "Admin", component: AdminLayout, meta: {isAdmin: true, requiresAuth: true}, children: [
            {path: "/statistics", name: "Statistics", component: Statistics},
        ]
    },
    {
        path: "/auth", redirect: "login", name: "Auth", component: AuthLayout, meta: {isGuest: true}, children: [
            {path: "/login", name: "Login", component: Login},
            {path: "/register", name: "Register", component: Register},
        ]
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name: 'Login'})
    } else if (store.state.user.token && to.meta.isGuest ) {
        next({name: 'Dashboard'});
    }
    else if (store.state.user.token && to.meta.isGuest && store.state.user.data.role_as===1) {
        next({name: 'Admin'});
    }
    else if(to.meta.isUser && store.state.user.data.role_as === 1){
        next({name: 'Admin'});
    }
    else if(to.meta.isAdmin && store.state.user.data.role_as === 0){
        next({name: 'Dashboard'});
    }
    else {
        next();

    }
})
export default router;
