<template>
  <div class="MostReviewed container-xl w-100 h-auto rounded-lg space-y-4">
    <RenderBook
      :books="books"
      :loading="isLoading"
      :hideResult="false"
      header="Most Reviewed Book!"
    />
  </div>
</template>

<script>
import RenderBook from "../RenderBook.vue";
import BookController from "../../controllers/BookController";
import Book from "../common/Book.vue";
export default {
  name: "MostReviewed",
  components: { Book, RenderBook },
  data() {
    return {
      books: [],
      isLoading: false,
    };
  },
  async mounted() {
    this.isLoading = true;
    this.books = await BookController.getMostReviewed();
    this.isLoading = false;
  },
};
</script>

<style></style>
