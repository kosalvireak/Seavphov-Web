<template>
  <v-chart class="h-96 w-full lg:w-1/2" :option="chartOptions" autoresize />
</template>

<script>
export default {
  name: "BookCondition",
  data() {
    return {
      chartOptions: {
        title: {
          text: "Overview of book conditions",
          left: "left",
        },
        tooltip: {},
        legend: {
          orient: "vertical",
          left: "right",
          data: ["As-new", "Good", "Well-worn"],
        },
        series: [
          {
            name: "Number of book",
            type: "pie",
            data: [
              { value: 12, name: "As-new" },
              { value: 10, name: "Good" },
              { value: 6, name: "Well-worn" },
            ],

            radius: ["40%", "70%"],
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
