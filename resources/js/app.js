/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
         item:{},
         transacao:{status:'', mensagem:''}
    }
})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('marcas-component', require('./components/Marcas.vue').default);
Vue.component('table-marcas-component', require('./components/MarcasTabela.vue').default);
Vue.component('modal-component', require('./components/Modal.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('input-component', require('./components/Input.vue').default);
Vue.component('select-component', require('./components/Select.vue').default);


const app = new Vue({
    el: '#app', store
});
