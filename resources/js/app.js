require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
moment.locale('es');
/*------------Vue ProgressBar---------------*/

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});
/*------------Vue ProgressBar---------------*/

/*------------Vue Form---------------*/
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
/*------------Vue Form---------------*/

/*------------Vue Router---------------*/
import VueRouter from 'vue-router';
Vue.use(VueRouter);

const routes = [
    {path: '/dashboard', component: require('./components/DashboardComponent.vue').default},
    {path: '/users', component: require('./components/UsersComponent.vue').default},
    {path: '/profile', component: require('./components/ProfileComponent.vue').default}
];

const router = new VueRouter({
    routes,
    mode: 'history'
});
/*------------Vue Router---------------*/

/*------------Vue Pipes---------------*/

Vue.filter('capitalize', (text) => {
    if (!text) return '';
	return text.charAt(0).toUpperCase() + text.substr(1);
});

Vue.filter('dateFormat', (date) => {
    if (!date) return '';
    return moment(date).format('ll');
});

/*------------Vue Pipes---------------*/

/*------------Toasts---------------*/
import swal from 'sweetalert2';

window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 10000
});

window.toast = toast;

window.Fire = new Vue();

/*------------Toasts---------------*/


const app = new Vue({
    el: '#app',
    router,
    methods: {
        logout() {
            document.querySelector('#form-logout').submit()
        }
    }
});
