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

    <div v-if="hasOption" class="mt-3 col-span-4">
      <label :for="'category' + model.id" class="block text-sm font-medium text-gray-700"
        >Category</label
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
    </div>

    <div v-if="hasOption" class="mt-3 col-span-4">
      <label :for="'brand' + model.id" class="block text-sm font-medium text-gray-700"
        >Brand Name</label
      >
      <select
        :id="'brand' + model.id"
        :name="'brand' + model.id"
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

    <!-- Question -->
    <div class="mt-3 col-span-4">
      <label
        :for="'product_name' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Product Name</label
      >
      <input
        :id="'product_name' + model.id"
        :name="'product_name' + model.id"
        type="text"
        v-model="model.product_name"
        @change="dataChange"
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

    <div v-if="classification" class="mt-3 col-span-4">
      <label
        :for="'classification' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Classification</label
      >
      <input
        :id="'classification' + model.id"
        :name="'classification' + model.id"
        type="text"
        v-model="model.classification"
        @change="dataChange"
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

    <div v-if="productType" class="mt-3 col-span-4">
      <label
        :for="'product_type' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Product Type</label
      >
      <input
        :id="'product_type' + model.id"
        :name="'product_type' + model.id"
        type="text"
        v-model="model.product_type"
        @change="dataChange"
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

    <div v-if="formulation" class="mt-3 col-span-4">
      <label
        :for="'formulation' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Formulation</label
      >
      <input
        :id="'formulation' + model.id"
        :name="'formulation' + model.id"
        type="text"
        v-model="model.formulation"
        @change="dataChange"
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
        :for="'code' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Code</label
      >
      <input
        :id="'code' + model.id"
        :name="'code' + model.id"
        type="text"
        v-model="model.barcode"
        @change="dataChange"
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
    

    <div v-if="unit" class="mt-3 col-span-3">
      <label :for="'unit'+ model.id" class="block text-sm font-medium text-gray-700"
        >Product Unit</label
      >
      <select
        :id="'unit'+ model.id"
        :name="'unit'+ model.id"
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

    <div class="mt-3 pb-6 col-span-6">
      <label
        :for="'description' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Description</label
      >
      <textarea
        :id="'description' + model.id"
        :name="'description' + model.id"
        v-model="model.description"
        @change="dataChange"
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
   
    <div class="mt-3 col-span-4 overflow-hidden">
      <label
        
        class="block text-sm font-medium text-gray-700"
        >Image</label
      >
      <FormField help="Upload image" class="mt-1">
        <FormFilePicker label="Upload" type="file" @change="onImageChoose" />
      </FormField>
      
    </div>
    <div  class="mt-3 col-span-2 pt-3">
      <img v-if="model.image" class="sm:h-25" :src="model.image">
    </div>

   

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
const category_data = ref([]);
const classification = ref(false);
const productType = ref(false);
const formulation = ref(false);
const unit = ref(false);

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
  if(model.value.category_id){
    const data = categories.value.find(item => item.id === model.value.category_id);
    category_data.value = data;
  }
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

watch(category_data, (newVal)=> {
  // console.log(newVal.details_data)
  updateInputs(newVal.details_data);
});

const updateInputs = (data)=> {
  classification.value = changeCategory(data, 1);
  productType.value = changeCategory(data, 2);
  formulation.value = changeCategory(data, 3);
};

const changeCategory = (detailsData, id) => {
  const result = detailsData.find(item => item == id);
  return result !== undefined; // Returns true if 1 is found, otherwise false
};
</script>

<style></style>
