<template>
  <div class="RenderBook container-xl w-100 h-auto">
    <div
      v-if="!hideHeader"
      class="h-10 d-flex align-items-center justify-content-start"
    >
      <p class="h3">{{ header }}</p>
    </div>
    <div v-if="loading" class="h-96 w-100 flex-center">
      <Loader :size="40" />
    </div>
    <template v-else-if="books && books.length">
      <div
        v-if="hideResult"
        class="h-10 d-flex align-items-center justify-content-end p-4"
      >
        <p class="h6">Result: {{ books.length }} {{ resultBook }}</p>
      </div>
      <div class="d-flex gap-4 flex-wrap p-0 lg:p-4" :class="justifyClass">
        <Book v-for="book in books" :book="book" :key="book.id" />
      </div>
    </template>
    <SearchEmptyState v-else text="book" />
  </div>
</template>

<script>
import Book from "./common/Book.vue";
export default {
  name: "RenderBook",
  components: { Book },
  props: {
    hideHeader: {
      type: Boolean,
      default: false,
    },
    hideResult: {
      type: Boolean,
      default: true,
    },
    header: {
      type: String,
      default: "All books",
    },
    books: {
      type: Array,
      required: true,
    },
    loading: Boolean,
    center: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    resultBook() {
      if (this.books.length == 1) {
        return "Book";
      } else {
        return "Books";
      }
    },
    justifyClass() {
      return this.center ? "justify-content-center" : "justify-content-evenly";
    },
  },
};
</script>
