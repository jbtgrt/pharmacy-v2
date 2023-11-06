<script setup>
import { computed, ref, watchEffect } from 'vue'
import { mdiClose } from '@mdi/js'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import CardBox from '@/components/CardBox.vue'
import OverlayLayer from '@/components/OverlayLayer.vue'
import CardBoxComponentTitle from '@/components/CardBoxComponentTitle.vue'
import NotificationBarInCard from '@/components/NotificationBarInCard.vue'


const props = defineProps({
  notif: Object,
  title: {
    type: String,
    required: true
  },
  button: {
    type: String,
    default: 'info'
  },
  buttonLabel: {
    type: String,
    default: 'Done'
  },
  hasCancel: Boolean,
  modelValue: {
    type: [String, Number, Boolean],
    default: null
  },
  modalForm: {
    type: [String],
    default: null
  },
  notifValue: {
    type: [Object],
    default: null
  },
  classValue: String,
})

const emit = defineEmits(['update:modelValue', 'update:modalForm', 'update:notif', 'cancel', 'confirm', 'submit'])

const value = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const form = computed({
  get: () => props.modalForm,
  set: (value) => emit('update:modalForm', value)
})

const notifUp = computed({
  get: () => props.notifValue,
  set: (value) => emit('update:notif', value)
})

const confirmSubmit = (mode) => {
  form.value = mode
  emit(mode)
}

const confirmModal = (mode) => {
  value.value = false
  emit(mode)
}

const confirmCancel = (mode) => {
  value.value = false
  notifUp.value = null
  formStatusWithHeader.value = false
  emit(mode)
}

const confirm = () => confirmModal('confirm')

const cancel = () => confirmCancel('cancel')

const submitForm = () => confirmSubmit('submit');


const formStatusWithHeader = ref(true);

watchEffect(()=>{
  formStatusWithHeader.value = props.notif ? true : false;
})

// const formStatusCurrent = ref(0);
// formStatusCurrent.value = props.notif.status;

const formStatusOptions = ['info', 'success', 'danger', 'warning']

const formStatusSubmit = () => {
  formStatusCurrent.value = formStatusOptions[formStatusCurrent.value + 1]
    ? formStatusCurrent.value + 1
    : 0
}

window.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && value.value) {
    cancel()
  }
})
</script>

<template>
  <OverlayLayer v-show="value" @overlay-click="cancel">
    <CardBox
      v-show="value"
      :class="classValue"
      is-modal
      is-form
      is-hoverable
      @submit.prevent="submitForm"
    >
    <NotificationBarInCard
    v-if="formStatusWithHeader"
        :color="formStatusOptions[notif.status]"
        :is-placed-with-header="formStatusWithHeader"
      >
      <!-- <div v-if="notif.error">
        {{notif.error}}
        
      </div> -->
      <div v-if="notif.error">
        <div v-for="(field, i) of Object.keys(notif.error)" :key="i">
          <div v-for="(error, ind) of notif.error[field] || []" :key="ind">
            * {{ error }}
          </div>
        </div>
      </div>
      <span v-else ><b class="capitalize">{{ notif.success }}</b></span>
    </NotificationBarInCard>

      <CardBoxComponentTitle  :title="title">
        <BaseButton
          v-if="hasCancel"
          :icon="mdiClose"
          color="whiteDark"
          small
          rounded-full
          @click.prevent="cancel"
        />
      </CardBoxComponentTitle>

      <div class="space-y-3 mt-10">

        <slot />
      </div>

      <template #footer>
        <BaseButtons>
          <BaseButton :label="buttonLabel" :color="button" type="submit" />
          <BaseButton v-if="hasCancel" label="Cancel" :color="button" outline @click="cancel" />
        </BaseButtons>
      </template>
    </CardBox>
  </OverlayLayer>
</template>
