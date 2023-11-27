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
    label: 'Products',
    icon: mdiViewList,
    menu: [
      {
        label: 'Products',
        to: '/admin/products',
      },
      {
        label: 'Sell Products',
        to: '/admin/sell-products',
      },
      {
        label: 'Out-Stock',
        to: '/admin/link-2',
      },
      {
        label: 'Expired',
        to: '/admin/link-3',
      }
    ],
  },
  {
    to: '/admin/supplies',
    icon: mdiTable,
    label: 'Supplies'
  },
  {
    to: '/admin/sales',
    icon: mdiTable,
    label: 'Sales'
  },
  {
    to: '/admin/stocks',
    icon: mdiTable,
    label: 'Stocks'
  },
  {
    to: '/admin/reports',
    icon: mdiFileDocumentOutline,
    label: 'Reports'
  },
  {
    label: 'Transactions',
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
