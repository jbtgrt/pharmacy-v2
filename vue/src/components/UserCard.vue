 <script setup>
import { computed, ref } from 'vue'
import { useStore } from "vuex";
import { useMainStore } from '@/stores/main'
import { mdiCheckDecagram, mdiAccount } from '@mdi/js'
import BaseLevel from '@/components/BaseLevel.vue'
import UserAvatarCurrentUser from '@/components/UserAvatarCurrentUser.vue'
import CardBox from '@/components/CardBox.vue'
import FormCheckRadio from '@/components/FormCheckRadio.vue'
import PillTag from '@/components/PillTag.vue'

const mainStore = useMainStore()
const store = useStore();

const { profile } = defineProps({
  profile: Object,
});

</script>

<template>
  <CardBox>
    <BaseLevel type="justify-around lg:justify-center">
      <UserAvatarCurrentUser :avatar="profile.image" :username="`${profile.first_name} ${profile.last_name}`" class="xl:w-9/12 lg:mx-12 md:mx-8" />
      <div class="space-y-3 text-center md:text-left lg:mx-12">
        <div class="flex justify-center md:block">
         <h1 class="text-2xl">
          Hello, <b>{{ profile.first_name }} {{ profile.last_name }}</b
          >!
        </h1>
        </div>
        
        <p>Phone <b>{{profile.phone_number}} </b></p>
        <p>Email <b>{{profile.email}} </b></p>
        <div class="flex justify-center md:block">
          <!-- <PillTag :label="role" color="info" :icon="mdiAccount" />  -->
        </div>
      </div>
    </BaseLevel>
  </CardBox>
</template>
