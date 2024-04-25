<template>
  <div class="SeachResult mt-4">
    <a
      @click="
        () => {
          this.$router.push('/home');
        }
      "
      class="text-gray"
    >
      <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to home
    </a>
    <h4 class="mt-4">Search result for "{{ searchword }}"</h4>
    <RenderBook :books="getSearchBooks" />
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
export default {
  name: "SeachResult",
  components: { RenderBook },
  data() {
    return { searchword: "" };
  },
  computed: {
    getSearchBooks() {
      this.searchword = this.$store.getters.searchWord;
      let books = this.$store.getters.allBooks;
      return books.filter((book) =>
        book.title.toLowerCase().trim().includes(this.searchword)
      );
    },
  },
  mounted() {
    this.searchword = this.$store.getters.searchWord;
  },
};
</script>

<style scoped>
</style>