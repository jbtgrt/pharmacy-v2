<script setup>
import { ref, computed, watch, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from "vue-router";
import { mdiTableBorder, mdiPlus, mdiTableOff  } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import CardBox from '@/components/CardBox.vue'
import TableProduct from '@/mycomponents/TableProduct.vue'

import NotificationBar from '@/components/NotificationBar.vue'
import BaseDivider from '@/components/BaseDivider.vue'

import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

const route = useRoute();
const store = useStore();

const items = computed(() => store.state.productList);
const checkedProducts = computed(() => store.state.checkedProducts);
const categories = computed(() => store.state.categoryList);

const showtable = ref(true);
const checkedLength = ref(false);

watchEffect(()=> {
  showtable.value = items.value.length > 0 ? true : false;
  checkedLength.value = checkedProducts.value.length > 0 ? true : false;

});


</script>

<template>
  <SectionMain>
    <div v-for="(category, index) in categories" :key="category.id">
      {{category.category_name}}
      <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title">
        <BaseButtons>
          <BaseButton
            to="add-supply"
            :icon="mdiPlus"
            label="Add Supply"
            color="contrast"
            rounded-full
            small
          />
          <BaseButton
            to="add-product"
            :icon="mdiPlus"
            label="Add Product"
            color="contrast"
            rounded-full
            small
          />
        </BaseButtons>
      </SectionTitleLineWithButton>

      <CardBox class="mb-20">
        <CardBoxComponentEmpty />
      </CardBox>
    </div>
    <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title" main>
      <BaseButtons>
        <BaseButton
          v-if="checkedLength"
          to="add-supply"
          :icon="mdiPlus"
          label="Add Supply"
          color="contrast"
          rounded-full
          small
        />
        <BaseButton
          to="add-product"
          :icon="mdiPlus"
          label="Add Product"
          color="contrast"
          rounded-full
          small
        />
      </BaseButtons>
    </SectionTitleLineWithButton>

    <CardBox class="mb-20" has-table>
      <TableProduct v-if="showtable" checkable/>
      <CardBoxComponentEmpty v-else />
    </CardBox>

    

  </SectionMain>
</template>
