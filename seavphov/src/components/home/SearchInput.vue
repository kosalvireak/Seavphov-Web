<template>
  <form
    class="max-w-80 bg-white rounded-lg"
    v-on:submit.prevent="searchBooks()"
  >
    <div class="flex">
      <Dropdown
        class="w-auto"
        id="search-dropdown"
        id_content="search-dropdown_content"
      >
        <template #button>
          <button
            type="button"
            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 pl-4 pr-2 text-sm font-medium border text-center text-gray-900 bg-gray-100 rounded-s-lg hover:bg-gray-200"
          >
            All
            <i class="fa fa-caret-down ml-2"></i>
          </button>
        </template>
        <template #content>
          <ul
            class="w-fit py-2 text-sm text-gray-700"
            aria-labelledby="dropdown-button"
          >
            <li v-for="category in categories" :key="category">
              <button
                @click="searchCategory(category)"
                type="button"
                class="w-full px-4 py-2 hover:bg-gray-200"
              >
                {{ category }}
              </button>
            </li>
          </ul>
        </template>
      </Dropdown>
      <input
        class="border"
        type="search"
        v-model="keyword"
        id="search-dropdown"
        placeholder="Search..."
        required
      />
      <button
        type="submit"
        class="p-2.5 text-sm font-medium h-full text-white bg-seavphov rounded-e-lg border"
      >
        <i class="fa fa-magnifying-glass"></i>
        <span class="sr-only">Search</span>
      </button>
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

<style scoped></style>
