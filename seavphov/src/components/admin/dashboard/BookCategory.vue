<template>
  <v-chart class="h-96 w-full lg:w-1/2" :option="chartOptions" autoresize />
</template>
  
  <script>
export default {
  name: "BookCategory",
  data() {
    return {
      chartOptions: {
        title: {
          text: "Overview of book categories",
          left: "left",
        },
        tooltip: {},
        legend: {
          orient: "vertical",
          left: "right",
          data: [
            "Fiction",
            "Novel",
            "Text-Book",
            "History",
            "Science",
            "Fantasy",
          ],
        },
        series: [
          {
            name: "Number of book",
            type: "pie",
            roseType: "radius",
            data: [
              { value: 335, name: "Fiction" },
              { value: 310, name: "Novel" },
              { value: 234, name: "Text-Book" },
              { value: 135, name: "History" },
              { value: 248, name: "Science" },
              { value: 148, name: "Fantasy" },
            ],
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