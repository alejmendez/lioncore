/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  // {
  //   url: "/apps/email",
  //   name: "Email",
  //   slug: "email",
  //   icon: "MailIcon",
  //   i18n: "Email",
  // },
  {
    url: '/',
    name: 'Home',
    slug: 'home',
    icon: 'HomeIcon',
    i18n: 'menu.home'
  },
  {
    url: '/alumno/',
    name: 'Alumno',
    icon: 'UsersIcon',
    slug: 'alumno',
    i18n: 'menu.alumno',
    permission: 'alumno list'
  },
  {
    url: '/registro/',
    name: 'Registro',
    icon: 'CheckCircleIcon',
    slug: 'registro',
    i18n: 'menu.registro',
    permission: 'registro list'
  },
  {
    url: '/grafica/',
    name: 'Grafica',
    icon: 'PieChartIcon',
    slug: 'grafica',
    i18n: 'menu.grafica',
    permission: 'grafica view'
  },
  // section menu
  {
    header: 'Admin',
    icon: 'PackageIcon',
    i18n: 'menu.admin',
    items: [
      {
        url: '/user/',
        name: 'User',
        icon: 'UserIcon',
        slug: 'user',
        i18n: 'menu.user',
        permission: 'user list'
      },
      {
        url: '/role/',
        name: 'Role',
        icon: 'UsersIcon',
        slug: 'role',
        i18n: 'menu.role',
        permission: 'role list'
      }
    ]
  }
]
