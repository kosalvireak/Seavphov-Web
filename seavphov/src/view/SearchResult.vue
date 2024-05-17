<template>
  <div
    class="SearchResult container-sm mt-4 w-100 h-100 d-flex-center justify-content-start flex-column mh-100"
  >
    <a
      @click="
        () => {
          this.$router.push('/home');
        }
      "
      class="text-gray align-self-start"
    >
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to home
    </a>
    <h4 class="mt-4">Search result for "{{ searchKeyword }}"</h4>
    <RenderBook :books="Books" :loading="isLoading" />
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
export default {
  name: "SearchResult",
  components: { RenderBook },
  data() {
    return {
      searchKeyword: this.$route.query.q,
      filters: {
        title: "",
      },
      Books: [],
      isLoading: false,
    };
  },
  methods: {
    async getSearchBooks(keyword) {
      this.isLoading = true;
      this.filters.title = keyword;
      this.Books = await this.$store.dispatch(
        "fetchBooksWithFilter",
        this.filters
      );
      this.isLoading = false;
    },
  },
  computed: {
    params() {
      return this.$route.query.q;
    },
  },
  mounted() {
    this.searchKeyword = this.$route.query.q;
    this.getSearchBooks(this.searchKeyword);
  },
  watch: {
    params(newVal, oldVal) {
      if (newVal != oldVal) {
        this.searchKeyword = newVal;
        this.getSearchBooks(this.searchKeyword);
      }
    },
  },
};
</script>

<style scoped>
</style>