<template>
  <form
    class="Search-Book-Form w-100 !w-96 bg-white rounded-lg"
    v-on:submit.prevent="searchBooks()"
  >
    <FwbInput
      v-if="!isSearchRoute"
      v-model="keyword"
      placeholder="Search By Title, Category, Condition or Availability"
      size="md"
    >
      <template #prefix>
        <svg
          aria-hidden="true"
          class="w-5 h-5 text-gray-500 dark:text-gray-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
          />
        </svg>
      </template>
    </FwbInput>
  </form>
</template>

<script>
import { FwbInput, FwbTooltip } from "flowbite-vue";
export default {
  components: { FwbInput, FwbTooltip },
  name: "SearchInput",
  data() {
    return {
      keyword: "",
      categories: [
        "Fiction",
        "Novel",
        "Text-Book",
        "History",
        "Science",
        "Fantasy",
      ],
    };
  },
  methods: {
    searchBooks() {
      this.$router.push({ path: "/search", query: { q: this.keyword } });
      this.keyword = "";
    },
  },
  computed: {
    isSearchRoute() {
      return this.$route.name == "search";
    },
  },
};
</script>

<style scoped>
@media screen and (min-width: 768px) {
  .Search-Book-Form > div {
    width: 100%;
  }
}
</style>
