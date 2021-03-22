import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm'
import Axios from 'axios'
import vuetify from './plugins/vuetify'
//import isConnected from './guard/auth'

// Import the styles directly. (Or you could add them via script tags.)
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
Vue.config.productionTip = false;
Vue.use(VueRouter);
Vue.use(
    {
        install(Vue) {
            Vue.prototype.$axios = Axios.create()
        },
    },
);

const routes = [
    {
        path: '/', name:'Home',
        component: () => import('./pages/Home.vue'),
        beforeEnter (to, from, next) {
            if(!window.localStorage.getItem('token')) {
                next({name:'login'})
            } else {
                next({name:'Home'})
            }
        },
    },
    {
        path: '/login', name:'login',
        component: () => import('./pages/Auth.vue')
    },
    {
        /* TODO gestion parametre (id vehicule) */
        /* TODO gestion edition */
        path: '/detail', name:'detail',
        component: () => import('./pages/Detail.vue')
    },
    {
        /* TODO gestion parametre (id vehicule) */
        /* TODO gestion edition */
        path: '/edit', name:'edit',
        component: () => import('./pages/Detail.vue')
    },
    {
        path: '/usermanager', name:'usermanager',
        component: () => import('./pages/UserManager.vue')
    }
    ,
    {
        path: '/admin', name:'admin',
        component: () => import('./components/Admin.vue')
    }
]


const router = new VueRouter({
    // Delete # on routes
    // mode:"history",
    routes
});
new Vue({
    render: h => h(App),
    router,
    vuetify,
}).$mount('#app')