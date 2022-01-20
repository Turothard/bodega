/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require( 'jszip' );
require( 'pdfmake' );
require( 'datatables.net-bs4');
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
Vue.component('warehousebodega-vue', require('./components/warehouse/Bodega.vue').default);
Vue.component('warehouseinforme-vue', require('./components/warehouse/Informe.vue').default);
Vue.component('warehousepedido-vue', require('./components/warehouse/Pedido.vue').default);
Vue.component('warehousemantenedor-vue', require('./components/warehouse/Mantenedor.vue').default);
Vue.component('warehouseconfiguracion-vue', require('./components/warehouse/Configuracion.vue').default);
Vue.component('warehouseordencompra-vue', require('./components/warehouse/OrdenCompra.vue').default);
Vue.component('nofiticacion-vue', require('./components/configuraciones/notificaciones.vue').default);
Vue.component('operationservicio-vue', require('./components/operation/Servicio.vue').default);
Vue.component('operationinforme-vue', require('./components/operation/Informe.vue').default);
Vue.component('operationmantenedor-vue', require('./components/operation/Mantenedor.vue').default);
Vue.component('Formulario-vue', require('./components/operation/servicio/formulario/Formulario.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
const app = new Vue({
    el: '#app',
});
