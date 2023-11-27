<template>
  <canvas ref="root" />
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { Chart, BarController, CategoryScale, LinearScale, BarElement, Tooltip } from 'chart.js';

const props = defineProps({
  data: {
    type: Object,
    required: true
  }
});

const root = ref(null);
let chart;

Chart.register(BarController, CategoryScale, LinearScale, BarElement, Tooltip);

onMounted(() => {
  chart = new Chart(root.value, {
    type: 'bar',
    data: props.data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true // You can customize scale options here
        },
        x: {
          stacked: true // If you want stacked bars, for instance
        }
      },
      plugins: {
        legend: {
          display: true // You can modify the legend options
        }
      }
    }
  });
});

const chartData = computed(() => props.data);

watch(chartData, (data) => {
  if (chart) {
    chart.data = data;
    chart.update();
  }
});
</script>
