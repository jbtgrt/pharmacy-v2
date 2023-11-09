<script setup>
import { ref, computed, watchEffect } from 'vue'
import { useRoute } from "vue-router";
import { useStore } from 'vuex'
import { mdiMonitorCellphone, mdiTableBorder, mdiTableOff, mdiAccountPlusOutline, mdiAccount, mdiMail } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import CardBox from '@/components/CardBox.vue'
import TableUser from '@/mycomponents/TableUser.vue'

import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

const route = useRoute();
const store = useStore();

const items = computed(() => store.state.userList);

const showtable = ref(true);
watchEffect(()=> {
  showtable.value = items.value.length > 0 ? true : false;
});

</script>

<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title" main>
      <BaseButton
        to="add-user"
        :icon="mdiAccountPlusOutline"
        label="Add User"
        color="contrast"
        rounded-full
        small
      />
    </SectionTitleLineWithButton>

    <CardBox class="mb-6" has-table>
      <TableUser v-if="showtable"/>
      <CardBoxComponentEmpty v-else />
    </CardBox>

  </SectionMain>
</template>
