exports.router = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/Home.vue'),
    meta: {
      rule: 'editor'
    }
  }
]
