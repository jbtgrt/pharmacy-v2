<script setup>
import { ref, computed, watch } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from "vue-router";
import { mdiTableBorder, mdiPlus  } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import CardBox from '@/components/CardBox.vue'
import TableCategory from '@/mycomponents/TableCategory.vue'

const route = useRoute();

</script>

<template>

    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title" main>
        <BaseButton
          to="add-category"
          :icon="mdiPlus"
          label="Add Category"
          color="contrast"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>

      <CardBox class="mb-6" has-table>
        <TableCategory />
      </CardBox>

    </SectionMain>
</template>
