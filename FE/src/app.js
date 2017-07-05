import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import ElementUI from 'element-ui'
import 'normalize.css';
import 'element-ui/lib/theme-default/index.css';
import './less/app.less';
import App from './components/app.vue';
import { EventEmitter } from 'fbemitter';
import Promise from 'es6-promise';

Promise.polyfill();

EventEmitter.emitter = new EventEmitter();

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(ElementUI);

let store = new Vuex.Store(require('./stores/app.js'));

const router = new VueRouter({
    routes: [
        { path: '/dashboard', component: require('./components/dashboard.vue')},
        { path: '/model/market', component: require('./components/model_market.vue')},
        { path: '/task/task/:id', component: require('./components/task_task.vue')},
        { path: '/task/create/:mid', component: require('./components/task_task.vue')},
        { path: '/task/list', component: require('./components/task_list.vue')},
        { path: '/task/view', component: require('./components/task_view.vue')},
        { path: '/model/model', component: require('./components/model_model.vue')},
        { path: '/model/model/:id', component: require('./components/model_model.vue')},
        { path: '/model/view/:id', component: require('./components/model_view.vue')},
        { path: '/model/list', component: require('./components/model_list.vue')},
        { path: '/user/password', component: require('./components/user_password.vue')},
        { path: '/user/profile', component: require('./components/user_profile.vue')},
        { path: '/statistics/task/:tid', component: require('./components/statistics_task.vue')},
        { path: '/statistics/task', component: require('./components/statistics_task.vue')},
        { path: '/statistics/model', component: require('./components/statistics_model.vue')},
        { path: '/logout', component: (resolve) => {}},
        // 系统管理
        { path: '/admin/adduser', component: require('./components/admin/adduser.vue')},
        { path: '/admin/resetpassword', component: require('./components/admin/resetpassword.vue')},
        { path: '/admin/syslog', component: require('./components/admin/syslog.vue')},
        { path: '/admin/allschedule', component: require('./components/admin/allschedule.vue')},
        { path: '*', redirect: '/task/list'},
    ]
});
console.log(router);
var y = require('./components/statistics_model.vue');
var x = require('./components/admin/allschedule.vue');
console.log(y);
console.log(x);
const app = new Vue({
    store,
    router,
    render: h => h(App),
    created() {
        this.$store.dispatch('user.load');
    },
    mounted() {

    }
}).$mount('#app');

export default {};