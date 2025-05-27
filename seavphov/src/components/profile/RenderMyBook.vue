<template>
  <div class="RenderMyBook w-100 h-auto">
    <div
      v-if="isLoading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader />
    </div>
    <template v-else>
      <div v-if="!isBooksEmpty" class="space-y-4">
        <div class="h-12 d-flex align-items-center justify-content-between m-1">
          <p class="h6 mb-0">
            Result: {{ books.length }} {{ bookPluralize(books.length || 0) }}
          </p>
          <LoadingButton @click="toRouteName('add-book')" text="Add Book" />
        </div>
        <MyBook
          v-for="book in books"
          :book="book"
          :key="book.id"
          @delete-book="deleteBook($event)"
        />
      </div>
      <template v-else>
        <SearchEmptyState long-text="You don't have any book!" />
        <div class="flex-center align-items-start">
          <LoadingButton @click="toRouteName('add-book')" color="green"
            >Add Book Now</LoadingButton
          >
        </div>
      </template>
    </template>
  </div>
</template>

<script>
import BookController from "../../controllers/BookController";
import MyBook from "./MyBook.vue";
export default {
  name: "RenderMyBook",
  components: { MyBook },
  data() {
    return {
      books: [],
      isLoading: false,
    };
  },
  methods: {
    deleteBook(id) {
      this.books = this.books.filter((book) => book.id !== id);
    },
  },
  computed: {
    isBooksEmpty() {
      return this.books && this.books.length == 0;
    },
  },
  async mounted() {
    this.isLoading = true;
    this.books = await BookController.getMyBooks();
    this.isLoading = false;
  },
};
</script>
<style scoped>
@media only screen and (max-width: 576px) {
  .font-75 {
    font-size: 75%;
  }
}
</style>
