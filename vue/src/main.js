import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import store from './stores'
import router from './router'
import { useDarkModeStore } from './stores/darkMode.js'

import './css/main.css'

// Init Pinia
const pinia = createPinia()

// Create the darkMode store instance
const darkModeStore = useDarkModeStore(pinia)

// Initialize the dark mode setting from local storage
if (typeof localStorage !== 'undefined') {
  const darkModeValue = localStorage.getItem('darkMode')
  if (darkModeValue === '1') {
    darkModeStore.set(true)
  }
}

// Create Vue app
createApp(App).use(store).use(router).use(pinia).mount('#app')

// Dark mode
// Uncomment, if you'd like to restore persisted darkMode setting, or use `prefers-color-scheme: dark`. Make sure to uncomment localStorage block in src/stores/darkMode.js
// import { useDarkModeStore } from './stores/darkMode.js'

// const darkModeStore = useDarkModeStore(pinia)

// if (
//   (!localStorage['darkMode'] && window.matchMedia('(prefers-color-scheme: dark)').matches) ||
//   localStorage['darkMode'] === '1'
// ) {
//   darkModeStore.set(true)
// }

// Default title tag
const defaultDocumentTitle = 'PharmIMS'

// Set document title from route meta
router.afterEach((to) => {
  document.title = to.meta?.title
    ? `${to.meta.title} — ${defaultDocumentTitle}`
    : defaultDocumentTitle
})
