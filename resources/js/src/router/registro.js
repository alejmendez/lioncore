import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/registro',
      name: 'registro',
      component: () => import('@/views/registro/list/RegistroList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('registro.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: 'registro.title.list',
        rule: 'editor'
      }
    },
    {
      path: '/registro/new',
      name: 'registro-new',
      component: () => import('@/views/registro/form/RegistroForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('registro.title.view'), url: '/registro' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: 'registro.title.new',
        rule: 'editor'
      }
    },
    {
      path: '/registro/:id',
      name: 'registro-edit',
      component: () => import('@/views/registro/form/RegistroForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('registro.title.view'), url: '/registro' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: 'registro.title.edit',
        rule: 'editor'
      }
    }
  ]
}
