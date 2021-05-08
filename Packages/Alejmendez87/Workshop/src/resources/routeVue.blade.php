import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/{{ $nameModel }}',
      name: '{{ $nameModel }}',
      component: () => import('@/views/{{ $nameModel }}/list/{{ ucfirst($nameModel) }}List.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('{{ $nameModel }}.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: '{{ $nameModel }}.title.list',
        rule: 'editor'
      }
    },
    {
      path: '/{{ $nameModel }}/new',
      name: '{{ $nameModel }}-new',
      component: () => import('@/views/{{ $nameModel }}/form/{{ ucfirst($nameModel) }}Form.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('{{ $nameModel }}.title.view'), url: '/{{ $nameModel }}' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: '{{ $nameModel }}.title.new',
        rule: 'editor'
      }
    },
    {
      path: '/{{ $nameModel }}/:id',
      name: '{{ $nameModel }}-edit',
      component: () => import('@/views/{{ $nameModel }}/form/{{ ucfirst($nameModel) }}Form.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('{{ $nameModel }}.title.view'), url: '/{{ $nameModel }}' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: '{{ $nameModel }}.title.edit',
        rule: 'editor'
      }
    }
  ]
}
