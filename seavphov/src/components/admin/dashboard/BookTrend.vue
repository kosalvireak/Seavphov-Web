<template>
  <v-chart class="h-96 w-full lg:w-1/2" :option="chartOptions" autoresize />
</template>

<script>
export default {
  name: "BookTrend",
  data() {
    return {
      chartOptions: {
        title: {
          text: "Book Trend",
        },
        tooltip: {},
        xAxis: {
          data: ["January", "February", "March", "April", "May", "June"],
        },
        yAxis: {},
        series: [
          {
            name: "Number of book",
            type: "line",
            data: [5, 3, 6, 1, 7, 8],
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
