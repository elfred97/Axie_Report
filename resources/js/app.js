/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// const { default: VueRouter } = require('vue-router');

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';

import { store } from '../js/store/store';

import Form from 'vform';
window.Form = Form;

import VueRouter from 'vue-router';
Vue.use(VueRouter)

import axios from 'axios'
import Vueaxios from 'vue-axios';
Vue.use(Vueaxios, axios);

import moment from 'moment';
window.moment = moment;

import JSCharting from 'jscharting-vue';
Vue.component(JSCharting);

import VueEvents from 'vue-events'
Vue.use(VueEvents);

/* =============== Loader ================*/
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css'; // Import stylesheet
Vue.component('loading', Loading);

import VueNoty from 'vuejs-noty'
import 'vuejs-noty/dist/vuejs-noty.css'
Vue.use(VueNoty, {
    timeout: 1000,
    progressBar: false,
    layout: 'topCenter',
    theme: 'sunset',
    animation: {
        open : 'animated fadeInRight',
        close: 'animated fadeOutRight'
    }
    // closeWith: ['click', 'button'],
});

import Vuetable from 'vuetable-2';
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';
Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination', VuetablePagination);
Vue.component('vuetable-pagination-info', VuetablePaginationInfo);

/* DatePicker */
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
Vue.component('v-datepicker', DatePicker);

import VueAlertify from 'vue-alertify';
Vue.use(VueAlertify);

import VueModalTor from "vue-modaltor";
Vue.use(VueModalTor);

Vue.filter('formatDate', function(date){
    if(!date) return '';
    return moment(date).format('L');
});

Vue.component('dialog-component', require('./components/layout/DialogComponent.vue').default);
Vue.component('type-component', require('./components/layout/TypeComponent.vue').default);
Vue.component('header-component', require('./components/layout/HeaderComponent.vue').default);
Vue.component('copyright-component', require('./components/layout/CopyRightComponent.vue').default);
Vue.component('footer-component', require('./components/layout/FooterComponent.vue').default);

import { routes } from './routes';

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

router.beforeEach((to, from, next) => {
    next();
})

const app = new Vue(Vue.util.extend({ router, store })).$mount('#app');
