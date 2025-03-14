<template>
  <div class="NewestAddition container-xl w-100 h-auto rounded-lg space-y-4">
    <div class="h-10 d-flex align-items-center justify-content-start">
      <p class="h3">Newest addition!</p>
    </div>
    <div v-if="isLoading" class="h-96 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else>
      <div class="d-flex gap-4 flex-wrap justify-content-center">
        <Book v-for="book in books" :book="book" :key="book.id" />
      </div>
    </template>
  </div>
</template>

<script>
import BookController from "../../controllers/BookController";
import Book from "../common/Book.vue";
export default {
  name: "NewestAddition",
  components: { Book },
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
