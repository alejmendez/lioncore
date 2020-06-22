exports.router = [
  {
    path: '/property',
    name: 'property',
    component: () => import('@/views/property/list/PropertyList.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: 'Property' },
        { title: 'List', active: true }
      ],
      pageTitle: 'properties.title.list',
      rule: 'editor'
    }
  },
  {
    path: '/property/new',
    name: 'app-property-new',
    component: () => import('@/views/property/form/PropertyForm.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: 'Property', url: '/property' },
        { title: 'New', active: true }
      ],
      pageTitle: 'properties.title.new',
      rule: 'editor'
    }
  },
  {
    path: '/property/:id',
    name: 'app-property-edit',
    component: () => import('@/views/property/form/PropertyForm.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: 'Property', url: '/property' },
        { title: 'Edit', active: true }
      ],
      pageTitle: 'properties.title.edit',
      rule: 'editor'
    }
  }
]
