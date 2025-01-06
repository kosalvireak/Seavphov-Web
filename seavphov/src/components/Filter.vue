<template>
  <section class="Filter d-flex flex-column justify-content-start">
    <h5 class="text-xl">Category</h5>
    <ul>
      <li @click="searchCategory('Fiction')">Fiction</li>
      <li @click="searchCategory('Novel')">Novel</li>
      <li @click="searchCategory('Text-Book')">Text-Book</li>
      <li @click="searchCategory('History')">History</li>
      <li @click="searchCategory('Science')">Science</li>
      <li @click="searchCategory('Fantasy')">Fantasy</li>
    </ul>
    <h5>Condition</h5>
    <ul>
      <li @click="searchCondition('As-new')">As-new</li>
      <li @click="searchCondition('Good')">Good</li>
      <li @click="searchCondition('Well-worn')">Well-worn</li>
    </ul>
  </section>
</template>

<script>
export default {
  name: "Filter",
  methods: {
    searchCategory(param) {
      this.$router.push({
        path: "/search",
        query: { categories: param },
      });
    },
    searchCondition(param) {
      this.$router.push({
        path: "/search",
        query: { condition: param },
      });
    },
  },
};
</script>

<style scoped>
.Filter {
  border-left: 0.5px solid lightgray;
}
h5 {
  font-family: "Roboto Slab", serif;
}
li {
  color: gray;
  margin: 8px;
  padding-bottom: 2px;
  border-bottom: 0.5px solid lightgray;
}
li:hover {
  color: #37aba3;
  cursor: pointer;
}
ul {
  color: gray;
  cursor: pointer;
  margin-left: 10px;
  padding-right: 10px;
}
</style>
