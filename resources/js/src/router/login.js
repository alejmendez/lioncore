export default {
  router: [
    {
      path: '/login',
      name: 'page-login',
      component: () => import('@/views/pages/login/Login.vue'),
      meta: {
        permission: 'editor'
      },
      beforeEnter: (to, from, next) => {
        // Si existe un token, la sesion existe, por lo cual, redirecciona a home
        // if (window.localStorage.getItem('_token')) {
        if (!!window.localStorage.getItem('accessToken')) {
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
