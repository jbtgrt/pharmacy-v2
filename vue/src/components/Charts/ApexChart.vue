<template>
    <div class="example">
      <apexchart
        :width="width"
        :height="height"
        :options="options"
        :series="data"
      ></apexchart>
    </div>
  </template>
  
  <script>
import VueApexCharts from "vue3-apexcharts";
  
  export default {
    name: "Chart",
    props: {
      title: {
        type: String,
      },
      width: {
        type: Number,
      },
      height: {
        type: Number,
      },
      loading: {
        type: Boolean,
      },
    },
    components: {
      apexchart: VueApexCharts,
    },
    data: function () {
      return {
        data: [30, 40, 45, 50, 49, 60],
      };
    },
    computed: {
      options() {
        return {
          chart: {
            type: "donut",
          },
          title: {
            text: this.title,
            align: "left",
            style: {
              fontSize: "25px",
              fontWeight: "bold",
            },
          },
          plotOptions: {
            pie: {
              donut: {
                labels: {
                  show: true,
                  total: {
                    show: true,
                    label: "Total",
                    fontSize: "22px",
                    fontWeight: "bold",
                    color: "black",
                  },
                },
              },
            },
          },
          colors: [
            "#0066a4",
            "#0096f0",
            "#80c5fd",
            "#e2e2e2",
            "#a9a9a9",
            "#393939",
          ],
          noData: {
            text: this.loading ? "Loading..." : "No Data",
          },
          labels: [
            "Category 1",
            "Category 2",
            "Category 3",
            "Category 4",
            "Category 5",
            "Category 6",
            
          ],
        };
      },
    },
  };
  </script>