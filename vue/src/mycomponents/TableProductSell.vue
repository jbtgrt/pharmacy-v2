<script setup>
import { computed, ref, watchEffect, watch } from 'vue'
import { useStore } from 'vuex'
import { mdiEye, mdiTrashCan, mdiAccountEdit, mdiMagnify, mdiAsterisk, mdiPencil } from '@mdi/js'
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

const props = defineProps({
  checkable: Boolean,
  categoryID: Number,
  index: Number,
})

const emit = defineEmits(["check"]);

const store = useStore()

const isModalActive = ref(false)
const isModalEdit = ref(false)
const isModalDangerActive = ref(false)

const items = computed(() => store.state.sellProductList.filter(product => product.category_id == props.categoryID));
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
const checkedRows = ref([]);
const tableData = ref([]);

watch(items, ()=> {
  checkedRows.value = [];
});

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
  //tableData.value = servicesPaginated;
  // Filter items based on searchQuery and selectedRole
  filteredItems.value = items.value.filter((user) => {
    return (
      (user.product_name.toLowerCase().includes(searchQuery.value.toLowerCase()) )
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


//  watchEffect(()=> {
  //tableData.value = servicesPaginated;
//  })


// const deleteItem = (id) => {
//     store.dispatch("deleteProduct", id);
//     // .then((itemID)=> {  console.log(itemID)
//     //   const filtered =  computed(()=> servicesPaginated.value.filter(product => product.id !== itemID));
//     //   tableData.value = filtered;
//     store.commit('filterProduct', { product: id, category: props.categoryID });
//     // });
//   }

const remove = (arr, cb) => {
  const newArr = []

  arr.forEach((item) => {
    if (!cb(item)) {
      newArr.push(item)
    }
  })

  return newArr
}

const checked = (isChecked, client) => {
  if (isChecked) {
    checkedRows.value.push({id: client.id, category_id: client.category_id, category_name: client.category_name, brand_id: client.brand_id, brand_name: client.brand_name, product_name: client.product_name, batch_no: client.batch_no + 1  })
  } else {
    checkedRows.value = remove(checkedRows.value, (row) => row.id === client.id)
  }

  if(checkedRows.value.length){
    emit("check", {data: checkedRows.value, status: true});
  } else {
    emit("check", {data: checkedRows.value, status: false});
  }
}

function upperCaseFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function getDiscount(amount, type){
  let percentageValue = parseFloat(amount);
  let fixValue = amount;

  let discount = type == "Percentage" ? `${percentageValue}%` : `₱${fixValue}`;
  return discount;
}

function getMinimum(qty){
  let minimum = qty <= 1 ? 'No minimum' : `Min: ${qty}`;
  return minimum;
}

</script>

<template> 

  <CardBoxModal hasCancel v-model="isModalActive" title="Product Sell Details" classValue="flex overflow-x-auto shadow-lg max-h-modal w-11/12 md:w-3/5 lg:w-2/5 xl:w-5/12 z-50" >
    <div class=" mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
      <p class="mr-3 mb-3">Discount: </p> 
      <!--  -->
      <div v-if="Object(selectedRecord.discount_data).length" v-for="(record, i) of selectedRecord.discount_data" :key="i" class="ml-3 flex flex-row my-auto items-center">
        <span class="bg-indigo-100 text-indigo-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
            <path d="M20 6L9 17l-5-5"></path>
          </svg>
        </span> 
        {{ upperCaseFirst(record.label) }} ({{getDiscount(record.amount, record.type)}}) {{getMinimum(record.purchase_quantity)}}
      </div>
      <div v-else class="ml-3 flex flex-row">
        {{selectedRecord.discount_label}}
      </div>
    </div>
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
        <th>Selling Price</th>
        <th>Discount</th>
        <th>Batch No</th>
        <th>Batch Stocks</th>
        
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
        <td data-label="Selling Price">
          {{ record.original_price }}
        </td>
        <td data-label="Discount">
          {{ record.discount_label }}
        </td>
        <td data-label="Batch No" >
          {{ record.batch_no }}
        </td>
        <td data-label="Batch Stocks" >
          {{ record.batch_stocks }}
        </td>
        
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton color="info" :icon="mdiEye" small @click="showRecord(isModalActive = true, selectedRecord = record)" />
            <BaseButton color="success" :icon="mdiPencil " small :to="`/admin/edit-sell-product/${record.id}`" />
          </BaseButtons>
        </td>
      </tr>
      <!-- <tr v-else>
        <td>no records found</td>
      </tr> -->
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
