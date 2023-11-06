 <script setup>
import { computed, defineProps } from "vue";
import { useStore } from "vuex";
import UserAvatar from '@/components/UserAvatar.vue'

const store = useStore();

const { avatar, username } = defineProps({
  avatar: { type: String, default: ''},
  username: { type: String, default: ''}
});

const image = computed(() => `${store.state.user.data.image_url}`);
const name =  computed(() => `${store.state.user.data.full_name}`);
const Avatar = avatar ? avatar : image;
const Username = username ? username : name;


</script>

<template>
  <UserAvatar :username="Username" :avatar="Avatar">
    <slot />
  </UserAvatar>
</template>
