<script setup>
import { v4 as uuidv4 } from "uuid";
import { ref, computed, watch, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useRoute, useRouter } from "vue-router";
import { mdiAccount, mdiMail, mdiAsterisk, mdiFormTextboxPassword, mdiGithub,mdiAccountPlusOutline,mdiAlertCircle, mdiCloseCircleOutline, mdiCheckCircle, mdiClose, mdiHomeAccount, mdiPhoneOutline, mdiAt, mdiReload,mdiAccountTie, mdiPlus,mdiPlusBox   } from '@mdi/js'

import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'

import CardBox from '@/components/CardBox.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import UserCard from '@/components/UserCard.vue'

import NotificationBar from '@/components/NotificationBar.vue'
import ProductSellEditor from "@/mycomponents/editor/ProductSellEditor.vue";

const notificationSettingsModel = ref([])
const notificationsOutline = computed(() => notificationSettingsModel.value.indexOf('outline') > -1)

const route = useRoute();
const router = useRouter();
const store = useStore();

store.dispatch("getDiscountList");

// Create empty survey
let model = ref({
  records: []
});

const addForm = ref(true);
let formTitle = 'Submit';

// If the current component is rendered on survey update route we make a request to fetch survey
if (route.params.id) {
  store.dispatch("editSellProduct", route.params.id);
  addForm.value = false;
  formTitle = 'Update';
}

let errors = ref('');

// Watch to current survey data change and when this happens we update local model
watch(
  () => store.state.selectedSellProduct,
  (newVal, oldVal) => {
    model.update = true ;
    model.value.records = [{
          ...JSON.parse(JSON.stringify(newVal))
        }];
  }
);

const selected = computed(() => store.state.selectedSellProduct);



// next

function addService(index) {
  const newService = {
    id: uuidv4(),
    category_id: '',
    brand_id: '',
    unit_id: '',
    product_name: '',
    classification: '',
    product_type: '',
    formulation: '',
    barcode: '',
    image_url: '',
    description: '',
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
  store.dispatch("updateSellProduct", { ...model.value }).then(({ data }) => {
    store.commit("notify", {
      show: true,
      type: "success",
      title: 'Update Success!',
      message: [],
    });
    router.push({name: "admin-sell-products"});
  })
  .catch(err => {
    store.commit("alert", {
      show: true,
      type: "danger",
      title: 'Ensure that these requirements are met:',
      message: err.response.data.errors,
    });
  });
}
  
}

const notification = computed(() => store.state.notification)


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
         <!-- {{model.records}} -->
        <CardBox is-form @submit.prevent="submit">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div v-if="addForm" >
              <h3 class="text-2xl font-semibold flex items-center justify-between">
                Product  
                <!-- Add new question -->
                <button
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
                </button>
                <!--/ Add new question -->
              </h3>
              <div v-if="!model.records.length" class="text-center text-gray-600">
                You don't have any products created
              </div>
            </div>
            <div v-for="(service, index) in model.records" :key="service.id">
              <ProductSellEditor
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
              <BaseButton color="info" to="/admin/product" label="Cancel" outline />
            </BaseButtons>
          </template>
        </CardBox>
    </SectionMain>
</template>
