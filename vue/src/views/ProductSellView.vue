<script setup>
import { ref, computed, watch, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from "vue-router";
import { mdiTableBorder, mdiPlus, mdiTableOff, mdiPencil } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import CardBox from '@/components/CardBox.vue'
import TableProductSell from '@/mycomponents/TableProductSell.vue'

import NotificationBar from '@/components/NotificationBar.vue'
import BaseDivider from '@/components/BaseDivider.vue'

import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

const route = useRoute();
const store = useStore();

store.dispatch("getDiscountList");
store.dispatch("getCategoryList");
store.dispatch("getSellProductList");


const items = computed(() => store.state.sellProductList);
// const checkedProducts = computed(() => store.state.checkedProducts);
const categories = computed(() => store.state.categoryList);

const showtable = ref(true);
const checkedLength = ref(false);

// options with default values
const options = {
    defaultTabId: 1,
    activeClasses:
        'text-blue-500 nline-block p-4 border-b-2 rounded-t-lg hover:text-blue-600 hover:border-blue-300 dark:hover:text-blue-300',
    inactiveClasses:
        'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
};

const tabItems = ref([]);
const selectedCategory = ref(0);

watchEffect(()=> {
  tabItems.value = categories.value.map((category, index) => {
    return { ...category, active: index === 0 };
  });
  showtable.value = items.value.length > 0 ? true : false;
});

const activeCategory = computed(()=> tabItems.value.find(item => item.active === true))
const storeCategory = computed(()=> store.state.currentCategory);


const changeTab = (id) => {
  const filterRecords = items.value.filter(product => product.category_id == id);
  showtable.value = filterRecords.length > 0 ? true : false;
  
  tabItems.value.forEach(item => {
    if (item.id === id) {
      item.active = true; // Update the 'active' property to true for the found item
    } else {
      item.active = false; // Set 'active' property to false for other items
    }
  });
  checkedLength.value = false;
  store.commit("setCheckSellProductList", []);
};

const checkList = (data)=> {
  checkedLength.value = data.status;
  store.commit("setCheckSellProductList", data.data);
}

</script>

<template>
  <SectionMain> 
    <SectionTitleLineWithButton :icon="mdiTableBorder" :title="route.meta.title" main>
      <BaseButtons>
      
      </BaseButtons>
    </SectionTitleLineWithButton>

    <CardBox class="mb-20" has-table>
      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" >
          <li class="me-2" v-for="(category, index) in tabItems" :key="category.id">
            <button :class="[category.active ? options.activeClasses : options.inactiveClasses]" @click="changeTab(category.id)" >{{category.category_name}}</button>
          </li>
        </ul>
      </div>
      <TableProductSell v-if="showtable" :categoryID="activeCategory.id" @check="checkList"/>
      <CardBoxComponentEmpty v-else /> 
    </CardBox>

    

  </SectionMain>
</template>
