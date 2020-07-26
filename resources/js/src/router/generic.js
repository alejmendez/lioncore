export default {
  router: [
    {
      path: '/callback',
      name: 'auth-callback',
      component: () => import('@/views/Callback.vue'),
      meta: {
        Auth: true
      }
    },
    {
      path: '/lock-screen',
      name: 'page-lock-screen',
      component: () => import('@/views/pages/LockScreen.vue'),
      meta: {
        Auth: true
      }
    },
    {
      path: '/comingsoon',
      name: 'page-coming-soon',
      component: () => import('@/views/pages/ComingSoon.vue'),
      meta: {
        Auth: true
      }
    }
  ]
}
