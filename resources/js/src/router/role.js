import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/role',
      name: 'role',
      component: () => import('@/views/role/list/RoleList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('role.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: 'role.title.list',
        rule: 'editor'
      }
    },
    {
      path: '/role/new',
      name: 'role-new',
      component: () => import('@/views/role/form/RoleForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('role.title.view'), url: '/role' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: 'role.title.new',
        rule: 'editor'
      }
    },
    {
      path: '/role/:id',
      name: 'role-edit',
      component: () => import('@/views/role/form/RoleForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('role.title.view'), url: '/role' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: 'role.title.edit',
        rule: 'editor'
      }
    }
  ]
}
