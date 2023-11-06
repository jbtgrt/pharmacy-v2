<script setup>
import { computed, ref, onMounted } from 'vue'
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
} from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import CardBoxWidget from '@/components/CardBoxWidget.vue'
import CardBox from '@/components/CardBox.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'


</script>

<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Order Product" main>
    </SectionTitleLineWithButton>

    <section class="text-gray-600 body-font">
      <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-4">
          <div class="xl:w-1/4 md:w-1/2 p-4">
            <div class="bg-gray-100 p-6 rounded-lg">
              <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/720x400" alt="content">
              <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">SUBTITLE</h3>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-4">Chichen Itza</h2>
              <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waistcoat. Distillery hexagon disrupt edison bulbche.</p>
            </div>
          </div>
          <div class="xl:w-1/4 md:w-1/2 p-4">
            <div class="bg-gray-100 p-6 rounded-lg">
              <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/721x401" alt="content">
              <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">SUBTITLE</h3>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-4">Colosseum Roma</h2>
              <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waistcoat. Distillery hexagon disrupt edison bulbche.</p>
            </div>
          </div>
          <div class="xl:w-1/4 md:w-1/2 p-4">
            <div class="bg-gray-100 p-6 rounded-lg">
              <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/722x402" alt="content">
              <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">SUBTITLE</h3>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-4">Great Pyramid of Giza</h2>
              <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waistcoat. Distillery hexagon disrupt edison bulbche.</p>
            </div>
          </div>
          <div class="xl:w-1/4 md:w-1/2 p-4">
            <div class="bg-gray-100 p-6 rounded-lg">
              <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/723x403" alt="content">
              <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">SUBTITLE</h3>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-4">San Francisco</h2>
              <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit waistcoat. Distillery hexagon disrupt edison bulbche.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  </SectionMain>
</template>

