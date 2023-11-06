<script setup>
import { containerMaxW } from '@/config.js'
import BaseLevel from '@/components/BaseLevel.vue'

const year = new Date().getFullYear()
</script>

<template>
  <footer class="py-2 px-6" :class="containerMaxW">
    <BaseLevel>
      <div class="text-center md:text-left">
        <b>&copy;{{ year }}, <a>PharmIMS</a>.</b>
        <slot />
      </div>
      <div class="md:py-2">
        <a>
          <img class="w-auto h-8 md:h-6"  src="@/assets/PharmIMS-pharmacy.png" alt="PharmIMS LOGO" />
        </a>
      </div>
    </BaseLevel>
  </footer>
</template>
