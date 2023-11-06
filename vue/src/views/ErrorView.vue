<script setup>
import SectionFullScreen from '@/components/SectionFullScreen.vue'
import CardBox from '@/components/CardBox.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import LayoutGuest from '@/layouts/LayoutGuest.vue'
</script>

<template>
  <div class="bg-gray-50 dark:bg-slate-800 dark:text-slate-100">
    <SectionFullScreen v-slot="{ cardClass }" bg="pinkRed">
      <CardBox :class="cardClass">
        <!-- <template> -->
          <!--
            This example requires updating your template:

            ```
            <html class="h-full">
            <body class="h-full">
            ```
          -->
          <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
            <div class="text-center">
              <p class="text-base font-semibold text-indigo-600">404</p>
              <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page Error</h1>
              <p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn’t find the page you’re looking for.</p>
              <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="#" to="/dashboard" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back home</a>
              </div>
            </div>
          </main>
        <!-- </template> -->


       <!--  <template #footer>
          <BaseButtons>
            <BaseButton label="Done" to="/dashboard" color="danger" />
          </BaseButtons>
        </template> -->
      </CardBox>
    </SectionFullScreen>
  </div>
</template>
