<template>
  <section
    class="SearchResult container-sm d-flex flex-column w-100 h-100 align-items-start mb-auto"
  >
    <div class="mt-4 w-100 d-flex-center row align-items-start">
      <div class="col-9">
        <a
          @click="
            () => {
              this.$router.push('/home');
            }
          "
          class="text-gray align-self-start cursor-pointer"
        >
          <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Home
        </a>
        <h4 v-if="searchTitle" class="mt-4">
          Search result for "<span class="fw-bold">{{ searchTitle }}</span
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
        <RenderBook :books="Books" :loading="isLoading" />
      </div>
      <Filter class="col-3 pt-5 h-100" />
    </div>
    <div
      class="Vue3Carousel_Container mt-4 w-100 d-flex-center row align-items-start my-5"
      style="min-height: 220px; margin-top: 200px !important"
    >
      <Vue3Carousel />
    </div>
  </section>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import Filter from "../components/Filter.vue";
import Vue3Carousel from "../components/Vue3Carousel.vue";
export default {
  name: "SearchResult",
  components: { RenderBook, Filter, Vue3Carousel },
  data() {
    return {
      searchTitle: this.$route.query.q,
      searchCategory: this.$route.query.categories,
      searchCondition: this.$route.query.condition,
      filters: {},
      Books: [],
      isLoading: false,
    };
  },
  methods: {
    async getSearchBooks(keyword, type) {
      this.isLoading = true;
      if (type == "title") {
        this.filters.title = keyword;
      } else if (type == "categories") {
        this.filters.categories = keyword;
      } else {
        this.filters.condition = keyword;
      }
      this.Books = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
      this.isLoading = false;
    },
  },
  computed: {
    params() {
      return (
        this.$route.query.q ||
        this.$route.query.categories ||
        this.$route.query.condition
      );
    },
  },
  mounted() {
    this.searchTitle = this.$route.query.q;
    this.searchCategory = this.$route.query.categories;
    this.searchCondition = this.$route.query.condition;
    if (this.searchTitle) {
      this.getSearchBooks(this.searchTitle, "title");
    } else if (this.searchCategory) {
      this.getSearchBooks(this.searchCategory, "categories");
    } else {
      this.getSearchBooks(this.searchCondition, "condition");
    }
  },
  watch: {
    params(newVal) {
      if (this.searchTitle) {
        this.searchTitle = newVal;
        this.getSearchBooks(this.searchTitle, "title");
        this.$router.go(0);
      } else if (this.searchCategory) {
        this.searchCategory = newVal;
        this.getSearchBooks(this.searchCategory, "categories");
        this.$router.go(0);
      } else {
        this.searchCondition = newVal;
        this.getSearchBooks(this.searchCondition, "condition");
        this.$router.go(0);
      }
    },
  },
};
</script>

<style scoped>
</style>