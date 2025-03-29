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
        <div class="h-12 d-flex align-items-center justify-content-end m-1">
          <p class="h6">Result: {{ books.length }} Books</p>
        </div>
        <MyBook v-for="book in books" :book="book" :key="book.id" />
      </div>
      <div v-else class="h-100 w-100">
        <div
          class="h-auto d-flex flex-column justify-content-center align-items-center m-5"
        >
          <img
            src="/img/notfound.png"
            alt="not found"
            class="w-25 img-fluid mb-3 rounded rounded-7"
          />
          <h3>No books found...!</h3>
        </div>
      </div>
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
  computed: {
    isBooksEmpty() {
      if (this.books & (this.books.length == 0)) {
        return true;
      } else {
        return false;
      }
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
