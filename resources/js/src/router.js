/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [

    {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/',
          name: 'home',
          component: () => import('./views/Home.vue')
        },
        {
          path: '/page2',
          name: 'page-2',
          component: () => import('./views/Page2.vue')
        }
      ]
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
            path: '/callback',
            name: 'auth-callback',
            component: () => import('@/views/Callback.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/login',
            name: 'page-login',
            component: () => import('@/views/pages/Login.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/register',
            name: 'page-register',
            component: () => import('@/views/pages/Register.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/forgot-password',
            name: 'page-forgot-password',
            component: () => import('@/views/pages/ForgotPassword.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/reset-password',
            name: 'page-reset-password',
            component: () => import('@/views/pages/ResetPassword.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/lock-screen',
            name: 'page-lock-screen',
            component: () => import('@/views/pages/LockScreen.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/comingsoon',
            name: 'page-coming-soon',
            component: () => import('@/views/pages/ComingSoon.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/error-404',
            name: 'page-error-404',
            component: () => import('@/views/pages/Error404.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/error-500',
            name: 'page-error-500',
            component: () => import('@/views/pages/Error500.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/not-authorized',
            name: 'page-not-authorized',
            component: () => import('@/views/pages/NotAuthorized.vue'),
            meta: {
              rule: 'editor'
            }
          },
          {
            path: '/maintenance',
            name: 'page-maintenance',
            component: () => import('@/views/pages/Maintenance.vue'),
            meta: {
              rule: 'editor'
            }
          }
      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/error-404'
    }
  ]
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
