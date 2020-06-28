export default {
  router: [
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
}
