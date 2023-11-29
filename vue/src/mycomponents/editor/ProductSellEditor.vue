<template>
  <!-- Question index -->
  <div class="flex items-center justify-between">
    <h3 class="text-lg font-bold">
      {{ index + 1 }}. {{ model.product_name }}
    </h3>
    <div v-if="addForm" class="flex items-center">
      <!-- Add new question -->
      <button
        type="button"
        @click="addService()"
        class="
          flex
          items-center
          text-xs
          py-1
          px-3
          mr-2
          rounded-sm
          text-white
          bg-gray-600
          hover:bg-gray-700
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
            clip-rule="evenodd"
          />
        </svg>
        Add
      </button>
      <!--/ Add new question -->

      <!-- Delete question -->
      <button
        type="button"
        @click="deleteService()"
        class="
          flex
          items-center
          text-xs
          py-1
          px-3
          rounded-sm
          border border-transparent
          text-red-500
          hover:border-red-600
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
            clip-rule="evenodd"
          />
        </svg>
        Delete
      </button>
      <!--/ Delete question -->
    </div>
  </div>
  <!--/ Question index -->



  <div class="xl:grid gap-3 xl:grid-cols-12">

   <!--  <div v-if="hasOption" class="mt-3 col-span-4">
      <label :for="'category' + model.id" class="block text-sm font-medium text-gray-700"
        >Sale Unit</label
      >
      <select
        :id="'category' + model.id"
        :name="'category' + model.id"
        v-model="model.category_id"
        @change="typeChange"
        class="
          mt-1
          block
          w-full
          py-2
          px-3
          border border-gray-300
          bg-white
          rounded-md
          shadow-sm
          focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
          sm:text-sm
        "
      >
        <option value="">-- select category --</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ upperCaseFirst(category.category_name) }}
        </option>
      </select>
    </div> -->

    <div class="mt-3 col-span-4">
      <label
        :for="'cost_text_' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Product Cost</label
      >
      <input
        type="text"
        :name="'cost_text_' + model.id"
        disabled
        v-model="model.cost_per_piece"
        @change="dataChange"
        :id="'cost_text_' + model.id"
        class="
          mt-1
          focus:ring-indigo-500 focus:border-indigo-500
          block
          w-full
          shadow-sm
          sm:text-sm
          border-gray-300
          rounded-md
        "
      />
    </div>

    <div class="mt-3 col-span-4">
      <label
        :for="'cost_text_' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Selling Price</label
      >
      <input
        type="text"
        :name="'cost_text_' + model.id"
        v-model="model.original_price"
        @change="dataChange"
        :id="'cost_text_' + model.id"
        class="
          mt-1
          focus:ring-indigo-500 focus:border-indigo-500
          block
          w-full
          shadow-sm
          sm:text-sm
          border-gray-300
          rounded-md
        "
      />
    </div> 

    <!-- <div :class="[ selectOptions ? 'grid gap-3 grid-cols-12' : '' ] "> -->
 
     <div class="mt-3 col-span-4 mb-8">
      <label for="brand_id" class="block text-sm font-medium text-gray-700">Column Names</label>
      <div>
        <button
          type="button"
          @click="toggleDropdown"
          class="flex justify-between w-full px-3 py-2 mt-1 text-left border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
          <span v-if="selectedDiscounts.length === 0">-- Select Discount --</span>
          <span v-else-if="selectedDiscounts.length === discountData.length">All Options Selected</span>
          <span v-else>{{ selectedDiscounts.length }} option{{ selectedDiscounts.length > 1 ? 's' : '' }} selected</span>
          <svg
            v-if="isOpen"
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 ml-2 -mr-1 text-gray-400"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 12a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"
            />
            <path
              fill-rule="evenodd"
              d="M3 7a2 2 0 114 0 2 2 0 01-4 0zM13 7a2 2 0 114 0 2 2 0 01-4 0z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
      <div v-show="isOpen" class="absolute z-10 mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
        <div class="p-3">
          <label class="inline-flex items-center">
            <input type="checkbox" v-model="selectAll" @change="toggleAll">
            <span class="ml-2">Select All</span>
          </label>
        </div>
        <div v-for="data in discountData" :key="data.id" class="p-3 border-t border-gray-300">
          <label class="inline-flex items-center">
            <input type="checkbox" :value="data.id" v-model="selectedDiscounts" @change="checkOption" >
            <span class="ml-2">{{ upperCaseFirst(data.label) }} ({{getDiscount(data.amount, data.type)}}) {{getMinimum(data.pur_qty)}}</span>
          </label>
        </div>
      </div>
    </div>
  <!-- </div> -->
  </div>


  <BaseDivider  />
</template>

<script setup>
import { v4 as uuidv4 } from "uuid";
import { computed, ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { watchEffect, watch } from "vue"

import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import FormFilePicker from '@/components/FormFilePicker.vue'
import BaseDivider from '@/components/BaseDivider.vue'

const store = useStore();


const props = defineProps({
  service: Object,
  index: Number,
  selectOptions: Boolean,
  addForm: Boolean,
  hasOption: Boolean
});


const model = ref(JSON.parse(JSON.stringify(props.service)));
const discountData = computed(() => {
  // Assuming store.state.discountList is the array of objects
  return store.state.discountList.map(discount => ({
    id: discount.id,
    label: discount.label,
    amount: discount.amount,
    type: discount.type,
    pur_qty: discount.purchase_quantity,
  }));
});


const emit = defineEmits(["change", "addService", "deleteService"]);

// Discount
const isOpen = ref(false);
const selectAll = ref(false);
const selectedDiscounts = ref([]);

function toggleDropdown() {
  isOpen.value = !isOpen.value;
}

function toggleAll() {
  if (selectAll.value) {
    selectedDiscounts.value = discountData.value.map(brand => brand.id);
    model.value.discount = [...selectedDiscounts.value];
  } else {
    selectedDiscounts.value = [];
    model.value.discount = [];
  }
  dataChange();
}






function checkOption() {
  model.value.discount = [...selectedDiscounts.value];
  dataChange();
}

selectedDiscounts.value = [...model.value.discount];

if(selectedDiscounts.value.length == discountData.value.length){
  selectAll.value = true;
} else {
  selectAll.value = false;
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


function typeChange() {
  dataChange();
}

// Emit the data change
function dataChange() {
  const data = model.value;

  emit("change", data);
}

function addService() {
  emit("addService", props.index + 1);
}

function deleteService() {
  emit("deleteService", props.service);
}

</script>

<style></style>
