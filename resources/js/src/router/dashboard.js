export default {
  router: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/Home.vue'),
      meta: {
        Auth: true
      }
    }
  ]
}
