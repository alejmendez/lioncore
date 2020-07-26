export default {
  router: [
    {
      path: '/chat',
      name: 'chat',
      component: () => import('@/views/chat/Chat.vue'),
      meta: {
        permission: 'chat'
      }
    }
  ]
}
