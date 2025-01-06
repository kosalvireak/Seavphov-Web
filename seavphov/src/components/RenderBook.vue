<template>
  <div class="RenderBook container w-100 h-auto">
    <div v-if="loading" class="h-96 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else-if="books.length">
      <div class="h-10 d-flex align-items-center justify-content-end">
        <h6 class="p-0 m-0 fw-bold font-75">
          Result: {{ books.length }} {{ resultBook }}
        </h6>
      </div>
      <div class="d-flex gap-4 flex-wrap justify-content-center">
        <Book v-for="book in books" :book="book" :key="book.id" />
      </div>
    </template>
    <NoResult v-else />
  </div>
</template>

<script>
import Book from "./common/Book.vue";
import NoResult from "./common/NoResult.vue";
export default {
  name: "RenderBook",
  components: { Book, NoResult },
  props: {
    books: {
      type: Array,
      required: true,
    },
    loading: Boolean,
  },
  computed: {
    resultBook() {
      if (this.books.length == 1) {
        return "Book";
      } else {
        return "Books";
      }
    },
  },
};
</script>
