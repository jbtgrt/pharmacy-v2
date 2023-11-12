<script setup>
import { ref, computed, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from "vue-router";
import { mdiTableBorder, mdiPlus  } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import CardBox from '@/components/CardBox.vue'
import TableSupply from '@/mycomponents/TableSupply.vue'

import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

const route = useRoute();
const store = useStore();

const items = computed(() => store.state.productList);

const showtable = ref(true);
watchEffect(()=> {
  showtable.value = items.value.length > 0 ? true : false;
});

</script>

<template>

    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title" main>
    
      </SectionTitleLineWithButton>

      <CardBox class="mb-6" has-table>
        <TableSupply v-if="showtable" />
        <CardBoxComponentEmpty v-else />
      </CardBox>

    </SectionMain>
</template>
