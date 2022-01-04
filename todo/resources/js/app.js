/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const axios = require("axios");

window.Vue = require('vue').default;

Vue.component('todo-list', require('./components/TodoList.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#app',
});

function change () {
    app.$forceUpdate();
}
