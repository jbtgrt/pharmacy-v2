<script setup>
import UserAvatar from '@/components/UserAvatar.vue'

const props = defineProps({
  username: {
    type: String,
    required: true
  },
  avatar: {
    type: String,
    default: null
  },
})

</script>

<template>
  <UserAvatar :username="username" :avatar="avatar">
    <slot />
  </UserAvatar>
</template>
