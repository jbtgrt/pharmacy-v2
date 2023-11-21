import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiReact,
  mdiHistory,
  mdiCalendarArrowRight,
  mdiAccountGroupOutline,
  mdiShapeOutline,
  mdiFileDocumentOutline 
} from '@mdi/js'

export default [
  {
    to: '/admin/dashboard',
    icon: mdiMonitor,
    label: 'Dashboard'
  },
  {
    to: '/admin/user',
    icon: mdiAccountGroupOutline,
    label: 'Users'
  },
  {
    to: '/admin/category',
    icon: mdiShapeOutline ,
    label: 'Categories'
  },
  {
    to: '/admin/products',
    icon: mdiTable  ,
    label: 'Products'
  },
  {
    to: '/admin/supplies',
    icon: mdiTable,
    label: 'Supplies'
  },
  {
    to: '/admin/reports',
    icon: mdiFileDocumentOutline,
    label: 'Reports'
  },
  // {
  //   label: 'Tree View',
  //   icon: mdiViewList,
  //   menu: [
  //     {
  //       label: 'Link 1',
  //       to: '/admin/link-1',
  //     },
  //     {
  //       label: 'Link 2',
  //       to: '/admin/link-2',
  //     },
  //     {
  //       label: 'Link 3',
  //       to: '/admin/link-3',
  //     }
  //   ],
  // },
]
