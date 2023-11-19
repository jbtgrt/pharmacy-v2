<script setup>
import { computed, ref, watchEffect } from 'vue'
import { useStore } from "vuex";
import { useMainStore } from '@/stores/main'
import { mdiCheckDecagram, mdiPhoneOutline, mdiAccountEdit  } from '@mdi/js'
import BaseLevel from '@/components/BaseLevel.vue'
import SelectedUserAvatar from '@/components/SelectedUserAvatar.vue'
import CardBox from '@/components/CardBox.vue'
import FormCheckRadio from '@/components/FormCheckRadio.vue'
import FormCheckRadioGroup from '@/components/FormCheckRadioGroup.vue'
import PillTag from '@/components/PillTag.vue'
import BaseButton from '@/components/BaseButton.vue'

const store = useStore();

const { product } = defineProps({
  product: Object,
});

const currentRecord = ref({})

// function toggleLockAccount(){
//   currentUser.value = {
//     id: user.value.id,
//     locked: user.value.locked,
//   };
//   console.log(currentUser.value)
//   store.dispatch('lockUser', currentUser.value);
// }

</script>

<template>    
  <CardBox>
    <section class="text-gray-600 body-font">
      <div class="container mx-auto">
        <div class="lg:w-5/5 mx-auto flex flex-wrap">
          <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" :src="product.image">
          <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
            <h2 class="text-sm title-font text-gray-500 tracking-widest">PRODUCT NAME</h2>
            <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{product.product_name}}</h1>
            <p class="leading-relaxed">{{product.description}}</p>

            <div class=" mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
              <div class="flex">
                <p class="mr-3">Category: </p>
                {{ product.category_name }} 
              </div>
              <div class="flex">
                <p class="mr-3">Brand: </p>
                {{ product.brand_name }} 
              </div>
            </div>
            <div class="flex justify-between">
              <span class="title-font font-medium text-2xl text-gray-900">₱{{product.price}}</span>
              <!-- <BaseButton  color="success" :icon="mdiAccountEdit" small :to="`/admin/edit-product/${product.id}`" /> -->
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </CardBox>
</template>
