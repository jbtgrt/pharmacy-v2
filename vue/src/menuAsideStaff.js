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
  mdiAccountGroupOutline 
} from '@mdi/js'

export default [
  {
    to: '/staff/dashboard',
    icon: mdiMonitor,
    label: 'Dashboard'
  },
  {
    to: '/staff/transaction',
    icon: mdiMonitor,
    label: 'Transaction'
  },
  {
    label: 'Tree View',
    icon: mdiViewList,
    menu: [
      {
        label: 'Link 1',
        to: '/staff/link-1',
      },
      {
        label: 'Link 2',
        to: '/staff/link-2',
      },
      {
        label: 'Link 3',
        to: '/staff/link-3',
      }
    ],
  },
  {
    to: '/staff/order-product',
    icon: mdiMonitor,
    label: 'Order Product'
  },
]
