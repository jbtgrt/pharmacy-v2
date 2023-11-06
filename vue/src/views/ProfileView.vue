<script setup>
import { ref, computed, watch, watchEffect } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from "vue-router";
import { 
  mdiAccount,
  mdiMail, 
  mdiAsterisk, 
  mdiFormTextboxPassword, 
  mdiGithub, 
  mdiClose, 
  mdiCheckCircle, 
  mdiAlertCircle, 
  mdiCogOutline  
} from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import CardBox from '@/components/CardBox.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import FormFilePicker from '@/components/FormFilePicker.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import UserCard from '@/components/UserCard.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import NotificationBar from '@/components/NotificationBar.vue'
const notificationSettingsModel = ref([])
const notificationsOutline = computed(() => notificationSettingsModel.value.indexOf('outline') > -1)

import CardBoxModal2 from '@/mycomponents/CardBoxModalForm.vue'
import DropdownButton from '@/mycomponents/DropdownButton.vue'


const store = useStore();
const route = useRoute();

const profile = ref({
  first_name: '',
  last_name: '',
  image_url: ''
});



// const submitProfile = () => {
//   mainStore.setUser(profile)
// }

const myDetails = computed(() => store.state.user.data);

const passwordForm = ref({})


watchEffect(() => {
  passwordForm.value.id = myDetails.value.id;
});

const success = ref(false);
const loading = ref(false);
let errors = ref({});
let status = '';

function onImageChoose(ev) {
  const file = ev.target.files[0];

  const reader = new FileReader();
  reader.onload = () => {
    // The field to send on backend and apply validations
    myDetails.value.image_url = reader.result;

    // The field to display here
    myDetails.value.image = reader.result;
    ev.target.value = "";
  };
  reader.readAsDataURL(file);
}

function submitProfile(ev) {
  ev.preventDefault();

  loading.value = true;
  store
    .dispatch('saveProfile', { ...myDetails.value })
    .then((res) => {
      loading.value = false;
      success.value = true;
      errors.value = '';
      status = 'Updated'
    })
    .catch(err => {
      success.value = false;
      loading.value = false;
      errors.value = err.response.data.errors;
    });
}

function submitPass(ev) {
    ev.preventDefault();
  
}

const isModalActive = ref(false);
const modalValue = ref('initial');
const modalNotification = ref(null);

const successModalNotification = (data) => {
  modalNotification.value = {
    success: data,
    status: 1
  }
}

const errorModalNotification = (data) => {
  modalNotification.value = {
    error: data,
    status: 2
  }
}

const handleUpdatedForm = (updatedValue) => {
  modalValue.value = updatedValue; // Update the parentValue with the updated value
  if(updatedValue == "submit") {
    loading.value = true;
    store
      .dispatch('changePassword', { ...passwordForm.value })
      .then((res) => {
        successModalNotification(res.data.message);
      })
      .catch(err => {
        errorModalNotification(err.response.data.errors);
      });
  }
};

const handleNotification = (updatedValue) => {
  modalNotification.value = updatedValue;
  passwordForm.value = {}
}

</script>

<template>
    
    <CardBoxModal2 classValue="shadow-lg max-h-modal w-11/12 md:w-3/5 lg:w-2/5 xl:w-4/12 z-50" v-model="isModalActive" @update:modalForm="handleUpdatedForm"  @update:notif="handleNotification" :notif="modalNotification" title="Change Password"
      button-label="Submit" has-cancel >
        <FormField label="Current password" help="Required. Your current password">
          <FormControl
            v-model="passwordForm.current_password"
            :icon="mdiAsterisk"
            name="password_current"
            type="password"
          />
        </FormField>

        <BaseDivider />

        <FormField label="New password" help="Required. New password">
          <FormControl
            v-model="passwordForm.password"
            :icon="mdiFormTextboxPassword"
            name="password"
            type="password"
            autocomplete="new-password"
          />
        </FormField>

        <FormField label="Confirm password" help="Required. New password one more time">
          <FormControl
            v-model="passwordForm.password_confirmation"
            :icon="mdiFormTextboxPassword"
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
          />
        </FormField>
    </CardBoxModal2>

    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiAccount" title="Profile" main>
        <BaseButton
          :icon="mdiCogOutline "
          color="contrast"
          rounded-full
          small
          @click="isModalActive = true"
        />
      </SectionTitleLineWithButton>
      

      <UserCard :profile="myDetails" class="mb-6" /> 

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
      <NotificationBar v-if="success" color="success" :icon="mdiCheckCircle" :outline="notificationsOutline">
        <b>Success!</b> {{status}}.
        <template #right>
          <BaseButton :icon="mdiClose" small rounded-full color="white" @click="success = false" />
        </template>
      </NotificationBar>
      <CardBox is-form @submit="submitProfile">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div>
            <FormField label="Avatar" help="Upload image">
              <FormFilePicker label="Upload" type="file" @change="onImageChoose" />
            </FormField>
            <FormField label="First Name" help="Required. Your first name">
              <FormControl
                v-model="myDetails.first_name"
                :icon="mdiAccount"
                name="first_name"
                autocomplete="first_name"
              />
            </FormField>
            <FormField label="Last Name" help="Required. Your last name">
              <FormControl
                v-model="myDetails.last_name"
                :icon="mdiAccount"
                name="last_name"
                autocomplete="last_name"
              />
            </FormField>
          </div>
          <div>
            <FormField label="E-mail" help="Required. Your e-mail">
              <FormControl
                v-model="myDetails.email"
                :icon="mdiMail"
                type="email"
                name="email"
                autocomplete="email"
              />
            </FormField>
            <FormField label="Phone" help="Optional. Your phone number">
              <FormControl
                v-model="myDetails.phone_number"
                :icon="mdiMail"
                type="text"
                name="phone_number"
                autocomplete="phone_number"
              />
            </FormField>
            <FormField label="Address" help="Optional. Your address">
              <FormControl
                v-model="myDetails.address"
                :icon="mdiMail"
                type="text"
                name="address"
                autocomplete="address"
              />
            </FormField>
          </div>
        </div>
        <template #footer>
          <BaseButtons>
            <BaseButton color="info" type="submit" label="Submit" />
          </BaseButtons>
        </template>
      </CardBox>


      
    </SectionMain>
</template>
