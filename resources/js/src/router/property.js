import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/property',
      name: 'property',
      component: () => import('@/views/property/list/PropertyList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('property.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: 'property.title.list',
        permission: 'property'
      }
    },
    {
      path: '/property/new',
      name: 'property-new',
      component: () => import('@/views/property/form/PropertyForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('property.title.view'), url: '/property' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: 'property.title.new',
        permission: 'property'
      }
    },
    {
      path: '/property/:id',
      name: 'property-edit',
      component: () => import('@/views/property/form/PropertyForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('property.title.view'), url: '/property' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: 'property.title.edit',
        permission: 'property'
      }
    }
  ]
}
