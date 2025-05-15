<template>
  <div class="NewestAddition container-xl w-100 h-auto rounded-lg space-y-4">
    <RenderBook
      :books="books"
      :loading="isLoading"
      :hideResult="false"
      header="Newest Addition Book!"
    />
  </div>
</template>

<script>
import RenderBook from "../RenderBook.vue";
import BookController from "../../controllers/BookController";
import Book from "../common/Book.vue";
export default {
  name: "NewestAddition",
  components: { Book, RenderBook },
  data() {
    return {
      books: [],
      isLoading: false,
    };
  },
  methods: {},
  async mounted() {
    this.isLoading = true;
    this.books = await BookController.fetchNewestAddition();
    this.isLoading = false;
  },
};
</script>

<style></style>
