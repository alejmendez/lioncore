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
    url: '/dashboard/analytics',
    name: 'Dashboard',
    slug: 'dashboard',
    icon: 'HomeIcon',
    i18n: 'Dashboard'
  },
  {
    header: 'Pages',
    icon: 'FileIcon',
    i18n: 'Pages',
    items: [
      {
        url: '/pages/profile',
        slug: 'page-profile',
        name: 'Profile',
        icon: 'UserIcon',
        i18n: 'Profile'
      },
      {
        url: '/pages/user-settings',
        slug: 'page-user-settings',
        name: 'User Settings',
        icon: 'SettingsIcon',
        i18n: 'UserSettings'
      },
      {
        url: '/pages/faq',
        slug: 'page-faq',
        name: 'FAQ',
        icon: 'HelpCircleIcon',
        i18n: 'FAQ'
      },
      {
        url: '/pages/knowledge-base',
        slug: 'page-knowledge-base',
        name: 'Knowledge Base',
        icon: 'InfoIcon',
        i18n: 'KnowledgeBase'
      },
      {
        url: '/pages/search',
        slug: 'page-search',
        name: 'Search',
        icon: 'SearchIcon',
        i18n: 'Search'
      },
      {
        url: '/pages/invoice',
        slug: 'page-invoice',
        name: 'Invoice',
        icon: 'InfoIcon',
        i18n: 'Invoice'
      },
    ]
  }
]

