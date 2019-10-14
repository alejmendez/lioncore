import Vue from 'vue'
import Router from 'vue-router'
import authRoutes from '../Modules/Auth/routes'

Vue.use(Router);

export default new Router({
    scrollBehavior() {
        return window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    // history: true,
    // mode: 'history',
    routes: [
        // Dashboards
        {
            path: '/',
            name: 'analytics',
            component: () => import('../DemoPages/Dashboards/Analytics.vue'),
        },
        ...authRoutes
    ]
})
