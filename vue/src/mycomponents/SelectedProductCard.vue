<script setup>
import { computed, ref, watch, watchEffect} from 'vue'
import { useStore } from 'vuex'
import { mdiCheckDecagram, mdiPhoneOutline, mdiAccountEdit  } from '@mdi/js'
import CardBox from '@/components/CardBox.vue'

const store = useStore();

const { product } = defineProps({
  product: Object,
});

//const categories = computed(() => store.state.categoryList);

//const categoryData = ref([]);

//const category = categories.value.find(item => item.id == product.category_id);
//categoryData.value = category; 


const classification = ref(true);
const productType =  ref(true);
const formulation =  ref(true);

// watchEffect(()=> {
//   updateCatData(categoryData.value.details_data); 
// })


  // classification.value = changeCategory(category.details_data, 1);
  // productType.value = changeCategory(category.details_data, 2);
  // formulation.value = changeCategory(category.details_data, 3);


// const changeCategory = (detailsData, id) => {
//   const result = detailsData.find(item => item == id);
//   return result !== undefined; // Returns true if 1 is found, otherwise false
// };


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
              <div v-if="classification" class="flex">
                <p class="mr-3">Classification: </p>
                {{ product.classification }} 
              </div>
              <div v-if="productType" class="flex">
                <p class="mr-3">Product Type: </p>
                {{ product.product_type }} 
              </div>
              <div v-if="formulation" class="flex">
                <p class="mr-3">Formulation: </p>
                {{ product.formulation }} 
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </CardBox>
</template>
