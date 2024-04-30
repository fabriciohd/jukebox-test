import moment from "moment";

require('./bootstrap');

window.Vue = require('vue').default;

import '@fortawesome/fontawesome-free/css/all.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import router from './router/router'

import '@mdi/font/css/materialdesignicons.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueMask from 'v-mask'
import store from './store/store'
import Vue from "vue";
import money from 'vuejs-money';
import VueCompositionAPI from '@vue/composition-api'

import { Chart, registerables } from "chart.js";

import firebase from 'firebase/compat/app';
import 'firebase/compat/auth';
import 'firebase/compat/firestore';

const firebaseConfig = {
    apiKey: "AIzaSyAl9moBJQLaaZn-xrVNX8b14wqEPSS95hM",
    authDomain: "jukebox-test-25c42.firebaseapp.com",
    projectId: "jukebox-test-25c42",
    storageBucket: "jukebox-test-25c42.appspot.com",
    messagingSenderId: "534783468438",
    appId: "1:534783468438:web:ad0fdabccf571602e1f3b7",
    measurementId: "G-7YCKC29FNY"
  };
  
  firebase.initializeApp(firebaseConfig);

Chart.register(...registerables);

Vue.use(Vuetify)
Vue.use(VueMask)
Vue.use(VueCompositionAPI)
Vue.use(money, {
    decimal: ',',
    thousands: '.',
    prefix: '',
    suffix: '',
    precision: 0,
    masked: false
})

const opts = {
    icons: {
        //iconfont: 'mdi'
        iconfont: 'md' || 'fa',
    },
    theme: {
        themes: {
            light: {
                primary: '#1e91cf',
                secondary: '#8e1ecf',
                accent: '#8c9eff',
                error: '#b71c1c',
            },
        },
    },
}

Vue.component('template-app', require('./App.vue').default);


Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});
Vue.filter('formatDateTime', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY - HH:mm')
    }
});

Vue.prototype.$getFormData = function(object) {
    const formData = new FormData();
    Object.keys(object).forEach(key => formData.append(key, object[key]));
    return formData;
}

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify(opts)
});
