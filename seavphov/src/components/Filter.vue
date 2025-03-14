<template>
  <section class="Filter d-flex flex-column justify-content-start">
    <p class="h4">Category</p>
    <ul>
      <li
        v-for="category in Category"
        :key="category"
        class="rounded-lg mx-2 px-2"
        :class="selectedCategory == category ? 'selectedList ' : ''"
        @click="searchCategory(category)"
      >
        {{ category }}
      </li>
    </ul>
    <p class="h4">Condition</p>
    <ul>
      <li
        v-for="condition in Condition"
        :key="condition"
        class="rounded-lg mx-2 px-2"
        :class="selectedCondition == condition ? 'selectedList ' : ''"
        @click="searchCondition(condition)"
      >
        {{ condition }}
      </li>
    </ul>
  </section>
</template>

<script>
export default {
  name: "Filter",
  props: {
    selectedCategory: String,
    selectedCondition: String,
  },
  data() {
    return {
      Category: [
        "Fiction",
        "Novel",
        "Text-Book",
        "History",
        "Science",
        "Fantasy",
      ],
      Condition: ["As-new", "Good", "Well-worn"],
    };
  },
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
li {
  color: gray;
  margin: 8px;
  padding-bottom: 2px;
  border-bottom: 0.5px solid lightgray;
}
.selectedList {
  color: white;
  cursor: pointer;
  background-color: var(--sp-primary);
}

li:hover {
  color: white;
  cursor: pointer;
  background-color: var(--sp-primary);
}
ul {
  color: gray;
  cursor: pointer;
}
</style>
