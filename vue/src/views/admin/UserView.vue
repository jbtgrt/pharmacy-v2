<script setup>
import { ref, computed } from 'vue'
import { useStore } from 'vuex'
import { mdiMonitorCellphone, mdiTableBorder, mdiTableOff, mdiAccountPlusOutline, mdiAccount, mdiMail } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import CardBox from '@/components/CardBox.vue'
import TableUser from '@/mycomponents/TableUser.vue'

</script>

<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiTableBorder" title="Users" main>
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
      <TableUser />
    </CardBox>

  </SectionMain>
</template>
