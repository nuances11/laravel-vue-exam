/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import App from './components/layout/App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import { routes } from './router';
import vuetify from './vuetify'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

let url = document.head.querySelector('meta[name=url').textContent;

Vue.prototype.baseUrl = url
Vue.prototype.apiUrl = url + 'api/'

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: routes
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('app-component', require('./components/layout/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    linkExactActiveClass: 'active',
    router,
    vuetify,
    render: h => h(App)
});
