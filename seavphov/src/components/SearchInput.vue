<template>
  <form class="max-w-xl mx-auto" v-on:submit.prevent="searchBooks()">
    <div class="flex">
      <label
        for="search-dropdown"
        class="mb-2 text-sm font-medium text-gray-900 sr-only"
        >Your Email</label
      >
      <button
        id="dropdown-button"
        data-dropdown-toggle="dropdown"
        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200"
        type="button"
      >
        All categories
        <svg
          class="w-2.5 h-2.5 ms-2.5"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 10 6"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 4 4 4-4"
          />
        </svg>
      </button>
      <div
        id="dropdown"
        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44"
      >
        <ul
          class="py-2 text-sm text-gray-700"
          aria-labelledby="dropdown-button"
        >
          <li v-for="category in categories" :key="category">
            <button
              @click="searchCategory(category)"
              type="button"
              class="inline-flex w-full px-4 py-2 hover:bg-gray-100"
            >
              {{ category }}
            </button>
          </li>
        </ul>
      </div>
      <div class="relative w-full">
        <input
          type="search"
          v-model="keyword"
          id="search-dropdown"
          class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300"
          placeholder="Search..."
          required
        />
        <button
          type="submit"
          class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-seavphov rounded-e-lg border"
        >
          <svg
            class="w-4 h-4"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 20 20"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
            />
          </svg>
          <span class="sr-only">Search</span>
        </button>
      </div>
    </div>
  </form>
</template>

<script>
import { FwbButton, FwbInput } from "flowbite-vue";
export default {
  components: { FwbInput, FwbButton },
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
    },
    searchCategory(param) {
      this.$router.push({
        path: "/search",
        query: { categories: param },
      });
    },
  },
  watch: {
    "$route.name"() {
      if (this.$route.name !== "search") {
        this.keyword = "";
      }
    },
  },
};
</script>


<style scoped>
</style>