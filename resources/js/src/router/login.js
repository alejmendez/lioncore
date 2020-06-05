exports.router = [
  {
    path: '/login',
    name: 'page-login',
    component: () => import('@/views/pages/login/Login.vue'),
    meta: {
      rule: 'editor'
    }
  },
  {
    path: '/register',
    name: 'page-register',
    component: () => import('@/views/pages/register/Register.vue'),
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
  }
]
