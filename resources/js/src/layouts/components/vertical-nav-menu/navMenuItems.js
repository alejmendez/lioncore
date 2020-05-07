/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    url: '/',
    name: 'Home',
    slug: 'home',
    icon: 'HomeIcon'
  },
  {
    header: 'Admin',
    icon: 'PackageIcon',
    i18n: 'Admin',
    items: [
      {
        url: '/user/',
        name: 'User',
        icon: 'UserIcon',
        slug: 'user',
        i18n: 'User'
      },
      {
        url: '/role/',
        name: 'Role',
        icon: 'UsersIcon',
        slug: 'role',
        i18n: 'Role'
      }
    ]
  },
]
