import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/grafica',
      name: 'grafica',
      component: () => import('@/views/grafica/list/GraficaList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('grafica.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: 'grafica.title.list',
        rule: 'editor'
      }
    },
    {
      path: '/grafica/new',
      name: 'grafica-new',
      component: () => import('@/views/grafica/form/GraficaForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('grafica.title.view'), url: '/grafica' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: 'grafica.title.new',
        rule: 'editor'
      }
    },
    {
      path: '/grafica/:id',
      name: 'grafica-edit',
      component: () => import('@/views/grafica/form/GraficaForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('grafica.title.view'), url: '/grafica' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: 'grafica.title.edit',
        rule: 'editor'
      }
    }
  ]
}
