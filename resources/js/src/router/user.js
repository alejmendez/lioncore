export default {
  router: [
    {
      path: '/user',
      name: 'user',
      component: () => import('@/views/user/user-list/UserList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: 'User' },
          { title: 'List', active: true }
        ],
        pageTitle: 'users.title.list',
        permission: 'user'
      }
    },
    {
      path: '/user/new',
      name: 'app-user-new',
      component: () => import('@/views/user/user-form/UserForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: 'User', url: '/user' },
          { title: 'New', active: true }
        ],
        pageTitle: 'users.title.new',
        permission: 'user'
      }
    },
    {
      path: '/user/:id',
      name: 'app-user-edit',
      component: () => import('@/views/user/user-form/UserForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: 'User', url: '/user' },
          { title: 'Edit', active: true }
        ],
        pageTitle: 'users.title.edit',
        permission: 'user'
      }
    }
  ]
}
