<script setup>
import { ref, computed } from 'vue'
import { useStore } from 'vuex'
import { mdiTableBorder } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import CardBox from '@/components/CardBox.vue'
import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

</script>

<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiTableBorder" title="Reports" main>

    </SectionTitleLineWithButton>

    <CardBox>
      <CardBoxComponentEmpty />
    </CardBox>

  </SectionMain>
</template>
