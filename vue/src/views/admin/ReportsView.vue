<script setup>
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { mdiTableBorder, mdiReload, mdiChartPie } from '@mdi/js';
import SectionMain from '@/components/SectionMain.vue';
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue';
import CardBox from '@/components/CardBox.vue';
import * as chartConfig from '@/components/Charts/chart.config.js'
import LineChart from '@/components/Charts/LineChart.vue'
import BaseButton from '@/components/BaseButton.vue'
import CardBoxComponentEmpty from '@/components/CardBoxComponentEmpty.vue';
import NotificationBar from '@/components/NotificationBar.vue';
import TableUser from '@/mycomponents/TableUser.vue';

import axiosClient from "@/axios.js";

const store = useStore();

import VueApexCharts from 'vue3-apexcharts';

const chartOptions = ref({

         chart: {
              height: 350,
              type: 'bar',
            },
            plotOptions: {
              bar: {
                borderRadius: 10,
                dataLabels: {
                  position: 'top', // top, center, bottom
                },
              }
            },
            dataLabels: {
              enabled: true,
              formatter: function (val) {
                return val + "%";
              },
              offsetY: -20,
              style: {
                fontSize: '12px',
                colors: ["#304758"]
              }
            },
            
            xaxis: {
              categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              position: 'top',
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },
              crosshairs: {
                fill: {
                  type: 'gradient',
                  gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                  }
                }
              },
              tooltip: {
                enabled: true,
              }
            },
            yaxis: {
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false,
              },
              labels: {
                show: false,
                formatter: function (val) {
                  return val + "%";
                }
              }
            
            },
            title: {
              text: 'Monthly Sales, 2003',
              floating: true,
              offsetY: 330,
              align: 'center',
              style: {
                color: '#444'
              }
            },
           
      });

const series = ref([
  {
    name: 'Inflation',
    data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
  },
]);

const showtable = ref(true); // Assuming you toggle this for table visibility
const notifications = ref([]); // You might add notifications data

// You can also import the necessary components here
 // const exportRecords = async () => {
 //    try {
 //      const response = await axiosClient.get('/export-reports'); // Adjust URL
 //          console.log(response.data.data)
 //          const blob = new Blob([response.data.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
 //          const link = document.createElement('a');
 //          link.href = window.URL.createObjectURL(blob);
 //          link.download = 'records.csv';
 //          link.click();
 //        } catch (error) {
 //          console.error('Error exporting records:', error);
 //        }
 //  };

// Inside your Vue component methods or wherever appropriate
const exportRecords = async () => {
  axiosClient.get('export-reports', {
    responseType: 'blob', // Ensure a blob response
  })
  .then(response => {
    const currentDate = new Date().toISOString().slice(0, 10); // Get current date (YYYY-MM-DD format)
    const filename = `data_${currentDate}.csv`;

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    link.parentNode.removeChild(link);
  })
  .catch(error => {
    console.error('Error downloading CSV:', error);
  });
}

const chartData = ref(null)

const months = ref(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
const sectionTitle = ref('January');

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData();
  getNextMonth();
}

const getNextMonth = () => {
      const currentMonthIndex = months.value.findIndex(month => month === sectionTitle.value);
      const nextMonthIndex = (currentMonthIndex + 1) % months.value.length;
      sectionTitle.value = months.value[nextMonthIndex];
    };

onMounted(() => {
  fillChartData()
})

const underConstruct = ()=> {
  const message = [
    "We apologize, but this feature is currently not available.",
    "Our team is working on implementing it soon.",
    "Thank you for your understanding!"
  ];

  store.commit("notify", {
      show: true,
      type: "info",
      seconds: 5000,
      title: 'Not available!',
      message: [message],
    });
}

</script>

<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiTableBorder" title="Reports Table" main >
     <BaseButton
        @click="underConstruct"
        label="Export Records"
        color="contrast"
        rounded-full
        small
      />
    </SectionTitleLineWithButton>
    
    <CardBox class="mb-6">
      <CardBoxComponentEmpty /> 
      <!-- <div id="chart">
        <VueApexCharts type="bar" height="350" :options="chartOptions" :series="series"/>
      </div> -->
    </CardBox> 

    <SectionTitleLineWithButton :icon="mdiChartPie" :title="`Sales of ${sectionTitle}`">
      <BaseButton :icon="mdiReload" color="whiteDark" @click="fillChartData" />
    </SectionTitleLineWithButton>

    <CardBox class="mb-6">
        <div v-if="chartData">
          <line-chart :data="chartData" class="h-96" />
        </div>
      </CardBox>

  </SectionMain>
</template>

<style scoped>

</style>

