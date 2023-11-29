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
        label: 'Stocks',
        to: '/admin/supplies',
      },
      {
        label: 'Discount',
        to: '/admin/discounts'
      },
      {
        label: 'Sell Products',
        to: '/admin/sell-products',
      },
      {
        label: 'Out-Stock',
        to: '/admin/out-stock',
      },
      {
        label: 'Expired',
        to: '/admin/expired',
      }
    ],
  },
  {
    label: 'Transactions',
    icon: mdiViewList,
    menu: [
      {
        label: 'Transactions',
        to: '/admin/transactions',
      },
      {
        label: 'Transaction History',
        to: '/admin/transaction-history',
      },
    ],
  },
  {
    to: '/admin/reports',
    icon: mdiFileDocumentOutline,
    label: 'Reports'
  },
  
]
