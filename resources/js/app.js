/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
moment.locale('pt-br');

import moment from 'moment'
import Echo from 'laravel-echo'
Vue.filter('formatDate', function (v) {
    if (v) {
        return moment(v).format('DD/MM/YYYY HH:mm')
    }
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('navbar-component', require('./components/navbar-component.vue').default);
Vue.component('navbar-list-component', require('./components/navbar-list-component.vue').default);
Vue.component('card-component', require('./components/card-component.vue').default);
Vue.component('login-component', require('./components/login-component.vue').default);
Vue.component('chat-component', require('./components/chat-component.vue').default);
Vue.component('register-component', require('./components/register-component.vue').default);
Vue.component('configuracoes-component', require('./components/configuracoes-component.vue').default);
Vue.component('meta-component', require('./components/meta-component.vue').default);
Vue.component('home-component', require('./components/home-component.vue').default);

/*
 *
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});
