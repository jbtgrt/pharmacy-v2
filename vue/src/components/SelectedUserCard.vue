<script setup>
import { computed, ref, defineProps, watchEffect } from 'vue'
import { useStore } from "vuex";
import { useMainStore } from '@/stores/main'
import { mdiCheckDecagram, mdiPhoneOutline  } from '@mdi/js'
import BaseLevel from '@/components/BaseLevel.vue'
import SelectedUserAvatar from '@/components/SelectedUserAvatar.vue'
import CardBox from '@/components/CardBox.vue'
import FormCheckRadio from '@/components/FormCheckRadio.vue'
import FormCheckRadioGroup from '@/components/FormCheckRadioGroup.vue'
import PillTag from '@/components/PillTag.vue'

const store = useStore();

const { user } = defineProps({
  user: Object,
});

const currentUser = ref({})

function toggleLockAccount(){
  currentUser.value = {
    id: user.value.id,
    locked: user.value.locked,
  };
  console.log(currentUser.value)
  store.dispatch('lockUser', currentUser.value);
}

</script>

<template>    
  <CardBox>
    <BaseLevel type="justify-around lg:justify-center">
      <SelectedUserAvatar :avatar="user.value.image_url" :username="user.value.first_name" class="lg:mx-12" />
      <div class="space-y-2 text-center md:text-left lg:mx-12">
        <div class="flex justify-start md:block">
          <FormCheckRadio
            v-model="user.value.locked"
            name="locked-switch"
            label="Lock Account"
            type="switch"
            :inputValue="true"
            @change="toggleLockAccount"
          />
        </div>
        <h1 class="text-2xl md:block">
          <b>{{ user.value.first_name }} {{ user.value.last_name }}</b>
        </h1>
        <p>Created at <b>{{ user.value.created_at }}</b></p>
        <p>Phone <b>{{ user.value.phone_number }}</b></p>
        <div class="flex justify-center md:block">
          <PillTag :label="user.value.role" color="info" :icon="mdiCheckDecagram" />
        </div>
      </div>
    </BaseLevel>
  </CardBox>
</template>
