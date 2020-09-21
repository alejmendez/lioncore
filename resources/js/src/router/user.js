import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/user',
      name: 'user',
      component: () => import('@/views/user/user-list/UserList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('users.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: 'users.title.list',
        permission: 'user'
      }
    },
    {
      path: '/user/new',
      name: 'user-new',
      component: () => import('@/views/user/user-form/UserForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('users.title.view'), url: '/user' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: 'users.title.new',
        permission: 'user'
      }
    },
    {
      path: '/user/:id',
      name: 'user-edit',
      component: () => import('@/views/user/user-form/UserForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('users.title.view'), url: '/user' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: 'users.title.edit',
        permission: 'user'
      }
    }
  ]
}
