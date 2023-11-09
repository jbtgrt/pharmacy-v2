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
    <!-- Question -->
    <div class="mt-3 col-span-3">
      <label
        :for="'question_text_' + model.product_name"
        class="block text-sm font-medium text-gray-700"
        >Product Name</label
      >
      <input
        type="text"
        :name="'question_text_' + model.product_name"
        v-model="model.product_name"
        @change="dataChange"
        :id="'question_text_' + model.product_name"
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


    <div v-if="hasOption" class="mt-3 col-span-3">
      <label for="question_type" class="block text-sm font-medium text-gray-700"
        >Category</label
      >
      <select
        id="question_type"
        name="question_type"
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
    </div>

    <div v-if="hasOption" class="mt-3 col-span-3">
      <label for="question_type" class="block text-sm font-medium text-gray-700"
        >Brand</label
      >
      <select
        id="question_type"
        name="question_type"
        v-model="model.brand_id"
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
        <option value="">-- select brand --</option>
        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
          {{ upperCaseFirst(brand.brand_name) }}
        </option>
      </select>
    </div>

    <div v-if="hasOption" class="mt-3 col-span-3">
      <label for="question_type" class="block text-sm font-medium text-gray-700"
        >Product Unit</label
      >
      <select
        id="question_type"
        name="question_type"
        v-model="model.unit_id"
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
        <option value="">-- select unit --</option>
        <option v-for="unit in units" :key="unit.id" :value="unit.id">
          {{ upperCaseFirst(unit.unit_name) }}
        </option>
      </select>
    </div>
  </div>

  <div class="xl:grid gap-3 xl:grid-cols-12">

   
    <div class="mt-3 col-span-4">
      <label
        :for="'question_text_' + model.data"
        class="block text-sm font-medium text-gray-700"
        >Image</label
      >
      <FormField help="Upload image" class="mt-1">
        <FormFilePicker label="Upload" type="file" @change="onImageChoose" />
      </FormField>
      
    </div>
    <div  class="mt-3 col-span-2">
      <img v-if="model.image" class="sm:h-40" :src="model.image">
    </div>

    <div class="mt-3 pb-6 col-span-6">
      <label
        :for="'service_description_' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Description</label
      >
      <textarea
        :name="'service_description_' + model.id"
        v-model="model.description"
        @change="dataChange"
        :id="'service_description_' + model.id"
        class="
          mt-1
          focus:ring-indigo-500 focus:border-indigo-500
          block
          w-full
          h-full
          shadow-sm
          sm:text-sm
          border-gray-300
          rounded-md
        "
      />
    </div>
   

  </div>

    <BaseDivider />
</template>

<script setup>
import { v4 as uuidv4 } from "uuid";
import { computed, ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { watchEffect } from "vue"

import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import FormFilePicker from '@/components/FormFilePicker.vue'
import BaseDivider from '@/components/BaseDivider.vue'

const store = useStore();

function onImageChoose(ev) {
  const file = ev.target.files[0];

  const reader = new FileReader();
  reader.onload = () => {
    // The field to send on backend and apply validations
    model.value.image_url = reader.result;

    // The field to display here
    model.value.image = reader.result;
    ev.target.value = "";

    dataChange();
  };
  reader.readAsDataURL(file);
  
}

const props = defineProps({
  service: Object,
  index: Number,
  selectOptions: Boolean,
  addForm: Boolean,
  hasOption: Boolean
});

// Get question types from vuex
const categories = computed(() => store.state.categoryList);

const brands = computed(() => store.state.brandList);
const units = computed(() => store.state.unitList);

const barcodeSymbology = [
    { id: 1 , label: 'Code 128' },
    { id: 2 , label: 'Code 39' },
    { id: 3 , label: 'UPC (Universal Product Code):' },
    { id: 4 , label: 'EAN (European Article Number)' },
    { id: 5 , label: 'QR Code (Quick Response Code)' },
    { id: 6 , label: 'Code 11' }
  ]

const model = ref(JSON.parse(JSON.stringify(props.service)));

const emit = defineEmits(["change", "addService", "deleteService"]);


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
