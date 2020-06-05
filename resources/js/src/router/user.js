exports.router = [
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
      rule: 'editor'
    }
  },
  {
    path: '/apps/user/user-view/:userId',
    name: 'app-user-view',
    component: () => import('@/views/user/UserView.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: 'User' },
        { title: 'View', active: true }
      ],
      pageTitle: 'users.title.view',
      rule: 'editor'
    }
  },
  {
    path: '/user/:userId',
    name: 'app-user-edit',
    component: () => import('@/views/user/user-form/UserForm.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: 'User' },
        { title: 'Form', active: true }
      ],
      pageTitle: 'users.title.edit',
      rule: 'editor'
    }
  }
]
