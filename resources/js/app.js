/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require( 'jszip' );
require( 'pdfmake' );
require( 'datatables.net-bs4' );
require( 'datatables.net-buttons-bs4' );
require( 'datatables.net-buttons/js/buttons.colVis.js' );
require( 'datatables.net-buttons/js/buttons.html5.js' );
require( 'datatables.net-buttons/js/buttons.print.js' );
require( 'datatables.net-responsive-bs4' );
require( 'datatables.net-scroller-bs4' );
require( 'datatables.net-select-bs4' );
window.Vue = require('vue');
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
import VueToastr from "vue-toastr";
// use plugin
Vue.use(VueToastr, {
  /* OverWrite Plugin Options if you need */
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys.map(key => Vue.component(key.split('/').pop.split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('bodega-vue', require('./components/Bodega.vue').default);
Vue.component('informe-vue', require('./components/Informe.vue').default);
Vue.component('pedido-vue', require('./components/Pedido.vue').default);
Vue.component('mantenedor-vue', require('./components/Mantenedor.vue').default);
Vue.component('configuracion-vue', require('./components/Configuracion.vue').default);
Vue.component('ordencompra-vue', require('./components/OrdenCompra.vue').default);
Vue.component('nofiticacion-vue', require('./components/configuraciones/notificaciones.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
const app = new Vue({
    el: '#app',
});
