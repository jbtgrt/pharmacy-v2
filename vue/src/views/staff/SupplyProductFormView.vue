<script setup>
import { v4 as uuidv4 } from "uuid";
import { ref, computed, watch, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useRoute, useRouter } from "vue-router";
import { mdiAccount, mdiMail, mdiAsterisk, mdiFormTextboxPassword, mdiGithub,mdiAccountPlusOutline,mdiAlertCircle, mdiCloseCircleOutline, mdiCheckCircle, mdiClose, mdiHomeAccount, mdiPhoneOutline, mdiAt, mdiReload,mdiAccountTie, mdiPlus,mdiPlusBox   } from '@mdi/js'

// import { ImageBarcodeReader } from "vue-barcode-reader";

import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'

import CardBox from '@/components/CardBox.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import UserCard from '@/components/UserCard.vue'

import NotificationBar from '@/components/NotificationBar.vue'

import SupplyProductEditor from "@/mycomponents/editor/SupplyProductEditor.vue";

const notificationSettingsModel = ref([])
const notificationsOutline = computed(() => notificationSettingsModel.value.indexOf('outline') > -1)

const route = useRoute();
const router = useRouter();
const store = useStore();

// Create empty survey
let model = ref({
  records: []
});

const addForm = ref(true);
let formTitle = 'Submit';

// If the current component is rendered on survey update route we make a request to fetch survey
if (route.params.id) {
  store.dispatch("editSupply", route.params.id);
  addForm.value = false;
  formTitle = 'Update';
}

let errors = ref('');

// Watch to current survey data change and when this happens we update local model
watch(
  () => store.state.selectedProductSupply,
  (newVal, oldVal) => {
    model.update = true ;
    model.value.records = [{
          ...JSON.parse(JSON.stringify(newVal))
        }];
  }
);

const selected = computed(() => store.state.selectedProductSupply);

const checkedProducts = computed(() => store.state.checkedProducts);

if (checkedProducts.value.length) {
   for (const item of checkedProducts.value) {
      model.value.records.push({ 
        id: uuidv4(), 
        product_id: item.id, 
        category_id: item.category_id, 
        brand_id: item.brand_id, 
        product_name: item.product_name, 
        category_name: item.category_name, 
        brand_name: item.brand_name, 
        batch_no: item.batch_no,
        supplier_id: '',
        unit_cost: 0, 
        quantity: 1, 
        total_cost: 0, 
        date_received: '',
        expires_at: '',
        storage_location: '',
        notes: ''
      });
    }
}

// next


function addService(index, data) {
  const newService = {
    id: uuidv4(),
    supplier_id: '',
    product_id: data.product_id,
    product_name: data.product_name,
    category_id: data.category_id,
    category_name: data.category_name,
    brand_id: data.brand_id,
    brand_name: data.brand_name,
    
    batch_no: data.batch_no ,
    date_received: '',
    expires_at: '',
    quantity: 1,
    unit_cost: 0,
    total_cost: 0,
    storage_location: '',
    notes: ''
  };

  model.value.records.splice(index, 0, newService);
}

function deleteService(records) {
  model.value.records = model.value.records.filter((q) => q !== records);
}

function serviceChange(service) {
  model.value.records = model.value.records.map((q) => {
    if (q.id === service.id) {
      return JSON.parse(JSON.stringify(service));
    }
    return q;
  });
}

function submit() {
 if (route.params.id) {
  store.dispatch("updateSupply", { ...model.value }).then(() => {
    router.push({name: "staff-supply"});
  })
  .catch(err => {
    errors.value = err.response.data.errors;
  });
} else {
  store.dispatch("saveSupply", { ...model.value }).then(() => {
    router.push({name: "staff-supply"});
  })
  .catch(err => {
    errors.value = err.response.data.errors;
  });
}
  
}

const notification = computed(() => store.state.notification)



// Scanner

// import ImageBarcodeReader from "@/mycomponents/scanner/ImageBarcodeReader.vue";
// import StreamBarcodeReader from "@/mycomponents/scanner/StreamBarcodeReader.vue";

// let decodedText = null;

// const handleDecode = (text) => {
//   decodedText = text;
//   // You can do something with the decoded text here
// };

// const handleResult = (result) => {
//   // Handle the result object if needed
// };

// const handleLoaded = () => {
//   // Handle the "loaded" event if needed
// };

</script>

<template>
    <SectionMain> 
      <SectionTitleLineWithButton :icon="mdiPlusBox " :title="route.meta.title" main>
      </SectionTitleLineWithButton>    
        <NotificationBar v-if="Object.keys(errors).length" color="danger" :icon="mdiAlertCircle" :outline="notificationsOutline">
          <div v-for="(field, i) of Object.keys(errors)" :key="i">
            <div v-for="(error, ind) of errors[field] || []" :key="ind">
              * {{ error }}
            </div>
          </div>
          <template #right>
            <BaseButton :icon="mdiClose" small rounded-full color="white" @click="errors = ''" />
          </template>
        </NotificationBar>
      
        <CardBox is-form @submit.prevent="submit">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div v-if="addForm" >
             <!--  <h3 class="text-2xl font-semibold flex items-center justify-between">
                Product   -->
                <!-- Add new question -->
                <!-- <button
                  type="button"
                  @click="addService()"
                  class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
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
                  Add Product
                </button> -->
                <!--/ Add new question -->
              <!-- </h3> -->
              <div v-if="!model.records.length" class="text-center text-gray-600">
                You don't have any supply products created
              </div>
            </div>
            <div v-for="(service, index) in model.records" :key="service.id">
              <SupplyProductEditor
                :service="service"
                :index="index"
                :addForm="addForm"
                hasOption
                @change="serviceChange"
                @addService="addService"
                @deleteService="deleteService"
              />
            </div>
          </div>
          

         
          <template #footer>
            <BaseButtons type="justify-end">
              <BaseButton type="submit" color="info" :label="formTitle" />
              <BaseButton color="info" to="/staff/supply" label="Cancel" outline />
            </BaseButtons>
          </template>
        </CardBox>
    </SectionMain>
</template>
