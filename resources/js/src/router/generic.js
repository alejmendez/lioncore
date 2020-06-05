exports.router = [
  {
    path: '/callback',
    name: 'auth-callback',
    component: () => import('@/views/Callback.vue'),
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
  }
]
