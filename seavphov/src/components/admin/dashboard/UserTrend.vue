<template>
  <v-chart class="h-96 w-full lg:w-1/2" :option="chartOptions" autoresize />
</template>

<script>
export default {
  name: "UserTrend",
  data() {
    return {
      chartOptions: {
        title: {
          text: "Total Books",
        },
        legend: {
          data: ['Number of book upload each months', 'Number of book in the systems']
        },
        tooltip: {},
        xAxis: {
          data: ["December", "January", "February", "March", "April", "May", "June"],
        },
        yAxis: {},
        series: [
          {
            name: "Number of book upload each months",
            type: "line",
            data: [0, 5, 3, 6, 1, 7, 8],
          },
          {
            name: "Number of book in the systems",
            type: "line",
            data: [0, 5, 8, 14, 15, 22, 30],
          },
        ],
      },
    };
  },
};
</script>

<style scoped>
.chart {
  height: 400px;
}
</style>
