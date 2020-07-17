export default {
  router: [
    {
      path: '/chat',
      name: 'chat',
      component: () => import('@/views/chat/Chat.vue'),
      meta: {
        rule: 'editor',
        no_scroll: true
      }
    }
  ]
}
