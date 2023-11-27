<script setup>
  import { ref, reactive, computed, watchEffect } from 'vue'
  import { useStore } from 'vuex'
  // import { useDarkModeStore } from '@/stores/darkMode.js'

  const store = useStore();

  const notification = computed(()=> store.state.notification);

  // const props = defineProps({
  //   bg: {
  //     type: String,
  //     required: true,
  //     validator: (value) => ['info', 'success', 'warning', 'danger'].includes(value)
  //   }
  // })



const colorClass = computed(() => {
  switch (notification.value.type) {
    case 'info':
      return 'text-blue-800 bg-blue-100'
    case 'success':
      return 'text-green-800 bg-green-100'
    case 'warning':
      return 'text-yellow-800 bg-yellow-100'
    case 'danger':
      return 'text-red-800 bg-red-100'
  }

  return ''
})

const dismiss = ()=> {
  notification.value.show = false;
}

</script>
<template>
  <div
    v-if="notification.show"
    :class="`${colorClass} fixed bottom-4 right-4 z-50 flex p-4 text-sm  rounded-lg  dark:bg-gray-800 dark:text-red-400`"
    role="alert"
  >
    <svg
      class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
      viewBox="0 0 20 20"
    >
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="sr-only">Danger</span>
    <div>
      <span class="font-medium">{{notification.title}}</span>
      <ul class="mt-1.5 list-disc list-inside">
        <div v-for="(field, i) of Object.keys(notification.message)" :key="i">
          <li v-for="(error, ind) of notification.message[field] || []" :key="ind">* {{ error }}</li>
        </div>
        <!-- <li>At least one lowercase character</li>
        <li>Inclusion of at least one special character, e.g., ! @ # ?</li> -->
      </ul>
    </div>
    <button @click="dismiss" class="ml-3 focus:outline-none">
      <svg
        class="w-4 h-4"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>
</template>