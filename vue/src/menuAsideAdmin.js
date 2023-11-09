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
  mdiShapeOutline 
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
    label: 'User'
  },
  {
    to: '/admin/category',
    icon: mdiAccountGroupOutline,
    label: 'Category'
  },
  {
    to: '/admin/product',
    icon: mdiAccountGroupOutline,
    label: 'Product'
  },
  {
    to: '/admin/supply-product',
    icon: mdiAccountGroupOutline,
    label: 'Supply'
  },
  {
    label: 'Tree View',
    icon: mdiViewList,
    menu: [
      {
        label: 'Link 1',
        to: '/admin/link-1',
      },
      {
        label: 'Link 2',
        to: '/admin/link-2',
      },
      {
        label: 'Link 3',
        to: '/admin/link-3',
      }
    ],
  },
]
