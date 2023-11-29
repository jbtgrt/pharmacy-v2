<template>
  <!-- Question index -->
  <div class="flex items-center justify-between">
    <h3 class="text-lg font-bold">
      {{ index + 1 }}. {{ model.label }}
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

    <!-- Question -->
    <div class="mt-3 col-span-4">
      <label
        :for="'discount_label' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Discount Label</label
      >
      <input
        :id="'discount_label' + model.id"
        :name="'discount_label' + model.id"
        type="text"
        v-model="model.label"
        @change="typeChange"
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
      <label :for="'discount_type' + model.id" class="block text-sm font-medium text-gray-700"
        >Type</label
      >
      <select
        :id="'discount_type' + model.id"
        :name="'discount_type' + model.id"
        v-model="model.type"
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
        <option value="">-- select type --</option>
        <option v-for="type in discountTypes" :key="type.id" :value="type.type_label">
          {{ upperCaseFirst(type.type_label) }}
        </option>
      </select>
    </div>

    <div class="mt-3 col-span-4">
      <label
        :for="'amount' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Discount Amount</label
      >
      <input
        :id="'amount' + model.id"
        :name="'amount' + model.id"
        type="text"
        v-model="model.amount"
        @input="handleAmountInput"
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
        :for="'purchase_quantity' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Purchase Quantity</label
      >
      <input
        :id="'purchase_quantity' + model.id"
        :name="'purchase_quantity' + model.id"
        type="number"
        min="1"
        v-model="model.purchase_quantity"
        @change="typeChange"
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
        :for="'start_date' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Start Date</label
      >
      <input
        :id="'start_date' + model.id"
        :name="'start_date' + model.id"
        type="date"
        v-model="model.start_date"
        @change="typeChange"
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
        :for="'end_date' + model.id"
        class="block text-sm font-medium text-gray-700"
        >End Date</label
      >
      <input
        :id="'end_date' + model.id"
        :name="'end_date' + model.id"
        type="date"
        v-model="model.end_date"
        @change="typeChange"
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

    

    
  </div>

  <BaseDivider  />
</template>

<script setup>
import { v4 as uuidv4 } from "uuid";
import { computed, ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { watchEffect, watch, onMounted } from "vue"

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

// Get question types from vuex
const discountTypes = computed(() => store.state.discountTypeList);

const model = ref(JSON.parse(JSON.stringify(props.service)));

const emit = defineEmits(["change", "addService", "deleteService"]);

const handleAmountInput = () => {
  let formattedAmount = model.value.amount.replace(/\D/g, '');
  model.value.amount = formattedAmount;

  dataChange();
};

function upperCaseFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
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
