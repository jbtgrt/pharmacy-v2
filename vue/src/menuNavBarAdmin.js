import {
  mdiMenu,
  mdiClockOutline,
  mdiCloud,
  mdiCrop,
  mdiAccount,
  mdiCogOutline,
  mdiEmail,
  mdiLogoutVariant,
  mdiLogout,
  mdiThemeLightDark,
  mdiGithub,
  mdiReact,
  mdiBellBadgeOutline 
} from '@mdi/js'

export default [
  // {
  //   icon: mdiMenu,
  //   label: 'Sample menu',
  //   menu: [
  //     {
  //       icon: mdiClockOutline,
  //       label: 'Item One'
  //     },
  //     {
  //       icon: mdiCloud,
  //       label: 'Item Two'
  //     },
  //     {
  //       isDivider: true
  //     },
  //     {
  //       icon: mdiCrop,
  //       label: 'Item Last'
  //     }
  //   ]
  // },
  {
    isCurrentUser: true,
    menu: [
      {
        icon: mdiAccount,
        label: 'My Profile',
        to: '/admin/profile'
      },
      // {
      //   icon: mdiCogOutline,
      //   label: 'Settings',
      //   to: '/styles'
      // },
      // {
      //   icon: mdiEmail,
      //   label: 'Messages'
      // },
      {
        isDivider: true
      },
      {
        icon: mdiLogout,
        label: 'Log Out',
        isLogout: true
      }
    ]
  },
  {
    icon: mdiThemeLightDark,
    label: 'Light/Dark',
    isDesktopNoLabel: true,
    isToggleLightDark: true
  },
  {
    icon: mdiLogoutVariant,
    label: 'Log out',
    isDesktopNoLabel: true,
    isLogout: true
  }
  // {
  //   icon: mdiGithub,
  //   label: 'GitHub',
  //   isDesktopNoLabel: true,
  //   href: 'https://github.com/justboil/admin-one-vue-tailwind',
  //   target: '_blank'
  // },
  // {
  //   icon: mdiBellBadgeOutline,
  //   label: 'Notification',
  //   isDesktopNoLabel: true,
  //   isSendNotif: true,
  // },

]
