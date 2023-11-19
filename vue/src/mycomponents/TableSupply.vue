<script setup>
import { computed, ref, watchEffect, watch } from 'vue'
import { useStore } from 'vuex'
import { mdiEye, mdiTrashCan, mdiAccountEdit, mdiMagnify, mdiAsterisk, mdiPencil    } from '@mdi/js'
import CardBoxModal from '@/components/CardBoxModal.vue'
import TableCheckboxCell from '@/components/TableCheckboxCell.vue'
import BaseLevel from '@/components/BaseLevel.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'
import UserAvatar from '@/components/UserAvatar.vue'
import UserCard from '@/components/UserCard.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'

import SelectedProductCard from '@/mycomponents/SelectedProductCard.vue'

defineProps({
  checkable: Boolean
})

const store = useStore()

const isModalActive = ref(false)
const isModalEdit = ref(false)
const isModalDangerActive = ref(false)

const items = computed(() => store.state.productSupplyList);

const selectedRecord = ref({});

function showRecord(client) {
  
}

const selectOptions = [
  { id: 5, label: '5 per page' },
  { id: 15, label: '15 per page' },
  { id: 30, label: '30 per page' }
]

const perPage = ref(5)
const currentPage = ref(0)
const searchQuery = ref('');
const selectedRows = ref('');
const filteredItems = ref([]);
const pageList = ref([]);
const numPages = ref(7);
const checkedRows = ref([])

// const numPages = computed(() => Math.ceil(items.value.length / perPage.value));
const calculateNumPages = computed(() => Math.ceil(items.value.length / perPage.value));
numPages.value = calculateNumPages;
const currentPageHuman = computed(() => currentPage.value + 1)

const pagesList = computed(() => {
  const pagesList = []
  for (let i = 0; i < numPages.value; i++) {
    pagesList.push(i)
  }
  return pagesList
})


// Add a watcher to update the filtered items when searchQuery or selectedRole changes
watchEffect(() => {

  // Filter items based on searchQuery and selectedRole
  filteredItems.value = items.value.filter((user) => {
    return (
      (user.product_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
       user.description.toLowerCase().includes(searchQuery.value.toLowerCase()))
    );
  });

  numPages.value = Math.ceil(filteredItems.value.length / perPage.value);

  // Reset currentPage to 0
  currentPage.value = 0;

  // Update pageList based on the new numPages
  pageList.value = [];
  for (let i = 0; i < numPages.value; i++) {
    pageList.value.push(i);
  }


});

// // Update the servicesPaginated computed property to use filteredItems
const servicesPaginated = computed(() => {
  return filteredItems.value.slice(perPage.value * currentPage.value, perPage.value * (currentPage.value + 1));
});

// const deleteItem = (id) => {
//       store.dispatch("deleteProduct", id);
//     }

// const remove = (arr, cb) => {
//   const newArr = []

//   arr.forEach((item) => {
//     if (!cb(item)) {
//       newArr.push(item)
//     }
//   })

//   return newArr
// }

// const checked = (isChecked, client) => {
//   if (isChecked) {
//     checkedRows.value.push({id: client.id, product_name: client.product_name, unit_name: client.unit_name})
//   } else {
//     checkedRows.value = remove(checkedRows.value, (row) => row.id === client.id)
//   }
//   store.commit("setCheckProductList", checkedRows.value);
// }


</script>

<template>

  <CardBoxModal v-model="isModalActive" title="Product Details" classValue="flex overflow-x-auto shadow-lg max-h-modal w-11/12 md:w-3/5 lg:w-2/5 xl:w-7/12 z-50" >
    <SelectedProductCard :product="selectedRecord" class="mb-6" />
  </CardBoxModal>

  <section class="p-4"> 
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="xl:flex xl:flex-wrap lg:flex lg:flex-wrap " >
        <FormField class="md:w-6/12 lg:w-4/12  xl:w-2/6 xl:mr-2 lg:mr-2">
          <FormControl v-model="perPage" :options="selectOptions" />
        </FormField>
      </div>
      <div class="xl:flex xl:justify-end lg:flex lg:justify-end">
        <FormField class="md:w-6/12 lg:w-4/6 xl:w-4/6">
          <FormControl v-model="searchQuery" :icon="mdiMagnify" />
        </FormField>
      </div>
    </div>
  </section>
  
  <table>
    <thead>
      <tr>
        <th v-if="checkable" />
        <th />
        <th>Product Name</th>
        <th>Batch No</th>
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Total Cost</th>
        <th>Date Received</th>
        <th>Expires At</th>
        <th>Category</th>
        <th>Brand</th>
        
        <th></th>

        <th />
      </tr>
    </thead>
    <tbody>
      <tr v-for="record in servicesPaginated" :key="record.id">
        <TableCheckboxCell v-if="checkable" @checked="checked($event, record)" />
        <td class="border-b-0 lg:w-6 before:hidden">
          <UserAvatar :username="record.product_name" :avatar="record.image" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
        </td>
        <td data-label="Product Name">
          {{ record.product_name }}
        </td>
        <td data-label="Batch No">
          {{ record.batch_no }}
        </td>
        <td data-label="Unit Cost">
          {{ record.unit_cost }}
        </td>

        <td data-label="Quantity">
          {{ record.quantity }}
        </td>
        <td data-label="Total Cost">
          {{ record.total_cost }}
        </td>
        <td data-label="Date Received">
          {{ record.date_received }}
        </td>
        <td data-label="Expires At">
          {{ record.expires_at }}
        </td>
        <td data-label="Category">
          {{ record.category_name }}
        </td>
         <td data-label="Brand">
          {{ record.brand_name }}
        </td>
       
         
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton color="info" :icon="mdiEye" small @click="showRecord(isModalActive = true, selectedRecord = record)" />
            <BaseButton color="success" :icon="mdiPencil" small :to="`/staff/edit-supply/${record.id}`" />
            <BaseButton color="danger" :icon="mdiTrashCan " small @click="deleteItem(record.id)" />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
    <BaseLevel>
      <BaseButtons>
        <BaseButton
          v-for="page in pagesList"
          :key="page"
          :active="page === currentPage"
          :label="page + 1"
          :color="page === currentPage ? 'lightDark' : 'whiteDark'"
          small
          @click="currentPage = page"
        />
      </BaseButtons>
      <small>Page {{ currentPageHuman }} of {{ numPages }}</small>
    </BaseLevel>
  </div>

</template>
