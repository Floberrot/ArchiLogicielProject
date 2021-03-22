import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm'
import Axios from 'axios'
import vuetify from './plugins/vuetify'

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
        path: '/login', name:'login',
        component: () => import('./components/Login.vue')
    },
    {
        path: '/register', name:'register',
        component: () => import('./components/Register.vue')
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