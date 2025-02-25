<template>
  <section
    class="SearchResult container-sm d-flex flex-column w-100 h-100 align-items-start mb-auto"
  >
    <div class="mt-4 w-100 flex-center row align-items-start">
      <div class="col-9">
        <BackRoute />
        <h4 v-if="searchTitle" class="mt-4">
          Search result for Title"<span class="fw-bold">{{ searchTitle }}</span
          >"
        </h4>
        <h4 v-if="searchCategory" class="mt-4">
          Search result for Category "<span class="fw-bold">{{
            searchCategory
          }}</span
          >"
        </h4>
        <h4 v-if="searchCondition" class="mt-4">
          Search result for Condition "<span class="fw-bold">{{
            searchCondition
          }}</span
          >"
        </h4>
        <RenderBook :books="Books" :loading="isLoading" :hideHeader="true" />
      </div>
      <Filter
        class="col-3 pt-5 h-100"
        :selectedCategory="searchCategory"
        :selectedCondition="searchCondition"
      />
    </div>
  </section>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import Filter from "../components/Filter.vue";
export default {
  name: "SearchResult",
  components: { RenderBook, Filter },
  data() {
    return {
      filters: {},
      Books: [],
      isLoading: false,
    };
  },
  methods: {
    checkAndSearchBook() {
      if (this.searchTitle) {
        this.getSearchBooks(this.searchTitle, "title");
      } else if (this.searchCategory) {
        this.getSearchBooks(this.searchCategory, "categories");
      } else {
        this.getSearchBooks(this.searchCondition, "condition");
      }
    },
    async getSearchBooks(keyword, type) {
      this.isLoading = true;
      this.filters[type] = keyword;
      this.Books = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters,
      );
      this.filters = {};
      this.isLoading = false;
    },
  },
  computed: {
    params() {
      return this.$route.query;
    },
    searchTitle() {
      return this.$route.query.q;
    },
    searchCategory() {
      return this.$route.query.categories;
    },
    searchCondition() {
      return this.$route.query.condition;
    },
  },
  mounted() {
    this.checkAndSearchBook();
  },
  watch: {
    params(newVal) {
      this.checkAndSearchBook();
    },
  },
};
</script>

<style scoped></style>
