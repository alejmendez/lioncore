exports.router = [
  {
    path: '/{{ $nameModel }}',
    name: '{{ $nameModel }}',
    component: () => import('@/views/{{ $nameModel }}/{{ $nameModel }}-list/{{ ucfirst($nameModel) }}List.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: '{{ ucfirst($nameModel) }}' },
        { title: 'List', active: true }
      ],
      pageTitle: '{{ $nameModelPlural }}.title.list',
      rule: 'editor'
    }
  },
  {
    path: '/{{ $nameModel }}/new',
    name: 'app-{{ $nameModel }}-new',
    component: () => import('@/views/{{ $nameModel }}/{{ $nameModel }}-form/{{ ucfirst($nameModel) }}Form.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: '{{ ucfirst($nameModel) }}', url: '/{{ $nameModel }}' },
        { title: 'New', active: true }
      ],
      pageTitle: '{{ $nameModelPlural }}.title.new',
      rule: 'editor'
    }
  },
  {
    path: '/{{ $nameModel }}/:id',
    name: 'app-{{ $nameModel }}-edit',
    component: () => import('@/views/{{ $nameModel }}/{{ $nameModel }}-form/{{ ucfirst($nameModel) }}Form.vue'),
    meta: {
      breadcrumb: [
        { title: 'Home', url: '/' },
        { title: '{{ ucfirst($nameModel) }}', url: '/{{ $nameModel }}' },
        { title: 'Edit', active: true }
      ],
      pageTitle: '{{ $nameModelPlural }}.title.edit',
      rule: 'editor'
    }
  }
]
