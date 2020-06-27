exports.router = [
  {
    path: '/{{ $nameModel }}',
    name: '{{ $nameModel }}',
    component: () => import('@/views/{{ $nameModel }}/list/{{ ucfirst($nameModel) }}List.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: '{{ ucfirst($nameModel) }}' },
        { title: 'List', active: true }
      ],
      pageTitle: '{{ $nameModel }}.title.list',
      rule: 'editor'
    }
  },
  {
    path: '/{{ $nameModel }}/new',
    name: 'app-{{ $nameModel }}-new',
    component: () => import('@/views/{{ $nameModel }}/form/{{ ucfirst($nameModel) }}Form.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: '{{ ucfirst($nameModel) }}', url: '/{{ $nameModel }}' },
        { title: 'New', active: true }
      ],
      pageTitle: '{{ $nameModel }}.title.new',
      rule: 'editor'
    }
  },
  {
    path: '/{{ $nameModel }}/:id',
    name: 'app-{{ $nameModel }}-edit',
    component: () => import('@/views/{{ $nameModel }}/form/{{ ucfirst($nameModel) }}Form.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: '{{ ucfirst($nameModel) }}', url: '/{{ $nameModel }}' },
        { title: 'Edit', active: true }
      ],
      pageTitle: '{{ $nameModel }}.title.edit',
      rule: 'editor'
    }
  }
]
