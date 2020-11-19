import i18n from '@/i18n/i18n'

export default {
  router: [
    {
      path: '/alumno',
      name: 'alumno',
      component: () => import('@/views/alumno/list/AlumnoList.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('alumno.title.view') },
          { title: i18n.t('common.list'), active: true }
        ],
        pageTitle: 'alumno.title.list',
        rule: 'editor'
      }
    },
    {
      path: '/alumno/new',
      name: 'alumno-new',
      component: () => import('@/views/alumno/form/AlumnoForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('alumno.title.view'), url: '/alumno' },
          { title: i18n.t('common.new'), active: true }
        ],
        pageTitle: 'alumno.title.new',
        rule: 'editor'
      }
    },
    {
      path: '/alumno/:id',
      name: 'alumno-edit',
      component: () => import('@/views/alumno/form/AlumnoForm.vue'),
      meta: {
        breadcrumb: [
          { title: 'Home', url: '/' },
          { title: i18n.t('alumno.title.view'), url: '/alumno' },
          { title: i18n.t('common.edit'), active: true }
        ],
        pageTitle: 'alumno.title.edit',
        rule: 'editor'
      }
    }
  ]
}
