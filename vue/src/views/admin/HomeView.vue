<script setup>
import { computed, ref, onMounted } from 'vue'
import { useStore } from 'vuex'
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiShape,
  mdiFolderAlert 
} from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import CardBoxWidget from '@/components/CardBoxWidget.vue'
import CardBox from '@/components/CardBox.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue'

import TodaySalesTable from '@/mycomponents/TodaySalesTable.vue'

import ApexChart from '@/components/Charts/ApexChart.vue'

const store = useStore();

const chartWidth = 450;
const chartHeight = 350;

// const chart = ref({
//   chart: {
//     type: 'pie'
//   },  
//   expandOnClick: true,
//   plotOptions: {
//     pie: {
//       dataLabels: {
//         minAngleToShowLabel: 0
//       }
//     }
//   },
//   options: {
//     colors: ['#E60B13', '#1F1E1E', '#6D6D6D', '#CECECE', 'rgba(255,87,93,.77)'],
//     legend: {
//       fontSize: '14px',
//       fontFamily: 'Helvetica, Arial',
//       fontWeight: 400,
//       itemMargin: {
//         vertical: 10
//       },
//       formatter: function(seriesName, opts) {
//         return '<div class="legend-info">' + '<span>' + seriesName + '</span>' + '<span>' + opts.w.globals.series[opts.seriesIndex] + '</span>' + '</div>'
//       }
//     },
//     dataLabels: {
//       enabled: false,
//     },
//     labels: ['data', 'data', 'data', 'data', 'data'],

//   },
//   series: [400, 400, 400, 400, 400]
//   });



</script>

<template>
  <SectionMain> {{  todaySales}}
    <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Overview" main>
    </SectionTitleLineWithButton>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 mb-6">
        <CardBoxWidget
          trend="15%"
          trend-type="up"
          color="text-emerald-500"
          :icon="mdiChartTimelineVariant"
          :number="512"
          prefix="$"
          label="Sales"
        />
        <CardBoxWidget
          trend="+55"
          trend-type="up"
          color="text-blue-500"
          :icon="mdiShape"
          :number="7770"
          label="Products"
        />
        <CardBoxWidget
          trend="Warning"
          trend-type="alert"
          color="text-red-500"
          :icon="mdiFolderAlert"
          :number="256"
          label="Expired Products"
        />
        <CardBoxWidget
          trend="+10"
          trend-type="up"
          color="text-green-500"
          :icon="mdiAccountMultiple"
          :number="256"
          label="Users"
        />
      </div>
      <section class="mb-6">
        <div class="container mx-auto">
          <div class="flex flex-wrap -m-4">
            <div class="p-4 md:w-1/2 w-full">
              <CardBox hasTable>
                <h1 class="font-bold">Today Sales</h1>
                <TodaySalesTable />
                <!-- <div class="h-full bg-gray-100 p-8 rounded">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">
                    <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                  </svg>
                  <p class="leading-relaxed mb-6">Synth chartreuse iPhone lomo cray raw denim brunch everyday carry neutra before they sold out fixie 90's microdosing. Tacos pinterest fanny pack venmo, post-ironic heirloom try-hard pabst authentic iceland.</p>
                  <a class="inline-flex items-center">
                    <img alt="testimonial" src="https://dummyimage.com/106x106" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
                    <span class="flex-grow flex flex-col pl-4">
                      <span class="title-font font-medium text-gray-900">Holden Caulfield</span>
                      <span class="text-gray-500 text-sm">UI DEVELOPER</span>
                    </span>
                  </a>
                </div> -->
              </CardBox>
            </div>
            <div class="p-4 md:w-1/2 w-full">
              <CardBox >
                <div class="chart-container">
                  <ApexChart
                    class="foo-chart"
                    :width="chartWidth"
                    :height="chartHeight"
                    :loading="loading"
                    title="Products"
                  />
                </div>
              </CardBox>
            </div>
          </div>
        </div>
      </section>
      
    <CardBox class="mb-6" has-table>
      <!-- <CardBoxComponentEmpty /> -->
      <TableSampleClients />
    </CardBox>

    
  </SectionMain>
</template>
