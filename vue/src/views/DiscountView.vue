<script setup>
import { ref, computed, watchEffect } from 'vue'
import { useRoute } from "vue-router";
import { useStore } from 'vuex'
import { mdiMonitorCellphone, mdiTableBorder, mdiTableOff, mdiAccountPlusOutline, mdiAccount, mdiMail, mdiPlus} from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import CardBox from '@/components/CardBox.vue'
import TableDiscount from '@/mycomponents/TableDiscount.vue'
import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

defineProps({
  role: String
})

const route = useRoute();
const store = useStore();

store.dispatch("getDiscountList");

const items = computed(() => store.state.discountList);

const showtable = ref(true);
watchEffect(()=> {
  showtable.value = items.value.length > 0 ? true : false;
});

</script>

<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title" main>
      <BaseButton
        to="add-discount"
        :icon="mdiPlus"
        label="Add Discount"
        color="contrast"
        rounded-full
        small
      />
    </SectionTitleLineWithButton>

    <CardBox class="mb-6" has-table>
      <TableDiscount v-if="showtable" :role="role" />
      <CardBoxComponentEmpty v-else />
    </CardBox>

  </SectionMain>
</template>
