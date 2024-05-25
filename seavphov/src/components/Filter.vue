<template>
  <section class="Filter d-flex flex-column justify-content-start">
    <h5>Category</h5>
    <ul>
      <li @click="SearchCategory('Fiction')">Fiction</li>
      <li @click="SearchCategory('Novel')">Novel</li>
      <li @click="SearchCategory('Text-Book')">Text-Book</li>
      <li @click="SearchCategory('History')">History</li>
      <li @click="SearchCategory('Science')">Science</li>
      <li @click="SearchCategory('Fantasy')">Fantasy</li>
    </ul>
    <h5>Condition</h5>
    <ul>
      <li @click="SearchCondition('As-new')">As-new</li>
      <li @click="SearchCondition('Good')">Good</li>
      <li @click="SearchCondition('Well-worn')">Well-worn</li>
    </ul>
  </section>
</template>

<script>
export default {
  name: "Filter",
  methods: {
    SearchCategory(param) {
      this.$router.push({
        path: "/search",
        query: { categories: param },
      });
    },
    SearchCondition(param) {
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