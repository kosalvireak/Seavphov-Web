<template>
  <v-chart class="h-96 w-full" :option="chartOptions" autoresize />
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
          data: ["New Books", "Total Books"],
        },
        tooltip: {},
        xAxis: {
          data: [
            "December",
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
          ],
        },
        yAxis: {},
        series: [
          {
            name: "New Books",
            type: "line",
            data: [0, 5, 3, 6, 1, 7, 8],
          },
          {
            name: "Total Books",
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
