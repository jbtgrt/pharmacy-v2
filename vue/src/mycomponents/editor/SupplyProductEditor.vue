<template>
  <!-- Question index -->
  <div class="flex items-center justify-between">
    <h3 class="text-lg">
      <span class="font-semibold">{{ index + 1 }}. {{ model.product_name }} </span>
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

  <div class="xl:grid lg:grid gap-3 xl:grid-cols-12 lg:grid-cols-12">
    <!-- Question -->
    <div class="mt-3 col-span-3">
      <label
        :for="'question_text_' + model.unit_name"
        class="block text-sm font-medium text-gray-700"
        >Product Unit</label
      >
      <input
        type="text"
        :name="'question_text_' + model.unit_name"
        v-model="model.unit_name"
        @change="dataChange"
        :id="'question_text_' + model.unit_name"
        disabled
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

    
    <div class="mt-3 col-span-3">
      <label
        :for="'question_text_' + model.product_code"
        class="block text-sm font-medium text-gray-700"
        >Product Code</label
      >
      <input
        type="text"
        :name="'question_text_' + model.product_code"
        v-model="model.product_code"
        @change="dataChange"
        :id="'question_text_' + model.product_code"
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

    <div class="mt-3 col-span-3">
      <label
        :for="'question_text_' + model.product_cost"
        class="block text-sm font-medium text-gray-700"
        >Product Cost</label
      >
      <input
        type="text"
        :name="'question_text_' + model.product_cost"
        v-model="model.product_cost"
        @change="dataChange"
        :id="'question_text_' + model.product_cost"
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

    
     <div class="mt-3 col-span-3">
      <label
        :for="'expire_text_' + model.expires_at"
        class="block text-sm font-medium text-gray-700"
        >Expires At</label
      >
      <input
        type="date"
        :name="'expire_text_' + model.expires_at"
        v-model="model.expires_at"
        @change="dataChange"
        :id="'expire_text_' + model.expires_at"
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

  <div class="xl:grid gap-3 xl:grid-cols-12">


    <div class="mt-3 pb-6 col-span-12">
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
  emit("addService", props.index + 1,  model.value);
}

function deleteService() {
  emit("deleteService", props.service);
}

</script>

<style></style>
