/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.VueResource = require('vue-resource').default;

Vue.use(VueResource);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('usuario-form-component', require('./components/form/UsuarioformComponent.vue').default);

Vue.component('menu-component', require('./components/MenuComponent.vue').default);
Vue.component('titulo-form-component', require('./components/TituloFormComponent.vue').default);
Vue.component('listagem-table-component', require('./components/ListagemTableComponent.vue').default);
Vue.component('modal-exclusao-component', require('./components/ModalExclusaoComponent.vue').default);
Vue.component('home-component', require('./components/HomeComponent.vue').default);
Vue.component('lista-vazia-component', require('./components/ListaVaziaComponent.vue').default);

Vue.component('conta-form-component', require('./components/form/ContaformComponent.vue').default);
Vue.component('receita-form-component', require('./components/form/ReceitaformComponent.vue').default);
Vue.component('despesa-form-component', require('./components/form/DespesaformComponent.vue').default);
Vue.component('categoria-form-component', require('./components/form/CategoriaformComponent.vue').default);
Vue.component('objetivo-form-component', require('./components/form/ObjetivoformComponent.vue').default);

Vue.component('receita-list-component', require('./components/list/ListReceitaComponent.vue').default);
Vue.component('despesa-list-component', require('./components/list/ListDespesaComponent.vue').default);
Vue.component('conta-list-component', require('./components/list/ListContaComponent.vue').default);
Vue.component('objetivo-list-component', require('./components/list/ListObjetivoComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
