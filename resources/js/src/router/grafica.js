import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/grafica',
      name: 'grafica',
      component: () => import('@/views/grafica/GraficaView.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('grafica.title.view'), active: true }
        ],
        pageTitle: 'grafica.title.view',
        rule: 'editor'
      }
    }
  ]
}
