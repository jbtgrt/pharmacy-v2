<script setup>
import { ref } from 'vue'
import { mdiCheckDecagram, mdiPhoneOutline, mdiAccountEdit  } from '@mdi/js'
import CardBox from '@/components/CardBox.vue'

const { product } = defineProps({
  product: Object,
});

const currentRecord = ref({})

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
              <div class="flex">
                <p class="mr-3">Supplier: </p>
                {{ product.supplier_name }} 
              </div>
              <div class="flex">
                <p class="mr-3">Expiration Date: </p>
                {{ product.expires_at }} 
              </div>
            </div>
            <div class="mb-2 flex justify-between">
              <h3 class="text-gray-500 text-s tracking-widest title-font">Product Cost</h3>
              <p>₱{{product.unit_cost}}</p>
            </div>
            <div class="mb-2 flex justify-between">
              <h3 class="text-gray-500 text-s tracking-widest title-font">Quantity</h3>
              <p>₱{{product.quantity}}</p>
            </div>
            <div class="flex justify-between mt-4">
              <h2 class="text-gray-900 title-font text-lg font-medium">Total Cost: </h2>
              <span class="text-gray-900 title-font text-lg font-medium">₱{{product.total_cost}}</span>              
            </div>
          </div>
        </div>
      </div>
    </section>
  </CardBox>
</template>
