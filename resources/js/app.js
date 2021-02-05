window._ = require('lodash');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
import Vuex from 'vuex'

Vue.use(VueAxios, axios);
Vue.use(Vuex);

axios.defaults.headers.post['X-CSRF-Token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

import App from './spa/App.vue';
import LoginComponent from './spa/Login.vue';
import RegisterComponent from './spa/Register.vue';
import ForgotPasswordComponent from './spa/ForgotPass.vue';
import ResetPasswordComponent from './spa/ResetPass.vue';


import Vuetify from 'vuetify';

Vue.use(Vuetify);

const vuetifyOptions = {};
const vuetify = new Vuetify(vuetifyOptions);

const routes = [
    {
        name: 'login',
        path: '/v2/login',
        component: LoginComponent
    },
    {
        name: 'register',
        path: '/v2/register',
        component: RegisterComponent
    },
    {
        name: 'forgot-password',
        path: '/v2/forgot-password',
        component: ForgotPasswordComponent
    },
    {
        name: 'reset-password',
        path: '/v2/reset-password',
        component: ResetPasswordComponent
    },

  ];

const router = new VueRouter({routes,  mode: 'history'});

const store =  new Vuex.Store({
    state: {
        logo: theme_options.logo,
    },
})

const app = new Vue({
    el: '#app',
    render: h=> h(App),
    router,
    vuetify,
    store: store,
})
