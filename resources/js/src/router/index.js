import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    scrollBehavior() {
        return window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    routes: [
        // Dashboards
        {
            path: '/',
            name: 'analytics',
            component: () => import('../DemoPages/Dashboards/Analytics.vue'),
        },
        // Pages
        {
            path: '/login',
            name: 'login',
            meta: {layout: 'userpages'},
            component: () => import('../DemoPages/UserPages/Login.vue'),
        },
        {
            path: '/pages/login-boxed',
            name: 'login-boxed',
            meta: {layout: 'userpages'},
            component: () => import('../DemoPages/UserPages/LoginBoxed.vue'),
        },
        {
            path: '/pages/register',
            name: 'register',
            meta: {layout: 'userpages'},
            component: () => import('../DemoPages/UserPages/Register.vue'),
        },
        {
            path: '/pages/register-boxed',
            name: 'register-boxed',
            meta: {layout: 'userpages'},
            component: () => import('../DemoPages/UserPages/RegisterBoxed.vue'),
        },
        {
            path: '/pages/forgot-password',
            name: 'forgot-password',
            meta: {layout: 'userpages'},
            component: () => import('../DemoPages/UserPages/ForgotPassword.vue'),
        },
        {
            path: '/pages/forgot-password-boxed',
            name: 'forgot-password-boxed',
            meta: {layout: 'userpages'},
            component: () => import('../DemoPages/UserPages/ForgotPasswordBoxed.vue'),
        },


    ]
})
