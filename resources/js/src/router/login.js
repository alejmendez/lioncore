import authService from '../auth/authService'

export default {
  router: [
    {
      path: '/login',
      name: 'page-login',
      component: () => import('@/views/pages/login/Login.vue'),
      meta: {
        Auth: false
      },
      beforeEnter: (to, from, next) => {
        if (authService.isAuthenticated()) {
          next({ path: '/' });
        } else {
          next();
        }
    },
    },
    {
      path: '/register',
      name: 'page-register',
      component: () => import('@/views/pages/register/Register.vue'),
      meta: {
        Auth: false
      }
    },
    {
      path: '/forgot-password',
      name: 'page-forgot-password',
      component: () => import('@/views/pages/ForgotPassword.vue'),
      meta: {
        Auth: false
      }
    },
    {
      path: '/reset-password',
      name: 'page-reset-password',
      component: () => import('@/views/pages/ResetPassword.vue'),
      meta: {
        Auth: false
      }
    }
  ]
}
