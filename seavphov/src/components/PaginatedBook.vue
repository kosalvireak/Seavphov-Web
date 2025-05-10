<template>
  <div>
    <RenderBook :books="books" :loading="isLoading" />
    <div
      v-if="books.length > 0"
      class="pagination d-flex align-items-center justify-content-center h-3rem mt-4"
    >
      <button
        @click="previous()"
        :disabled="isDisabledPrev"
        :class="{ '!cursor-not-allowed': isDisabledPrev || isLoading }"
      >
        &laquo;
      </button>
      <button
        v-for="page in last_page"
        :key="page"
        :class="[
          page == current_page ? 'active' : '',
          { '!cursor-not-allowed': isLoading },
        ]"
        @click="changePage(page)"
      >
        {{ page }}
      </button>
      <button
        @click="next()"
        :disabled="isDisabledNext"
        :class="{ '!cursor-not-allowed': isDisabledNext || isLoading }"
      >
        &raquo;
      </button>
    </div>
  </div>
</template>

<script>
import RenderBook from "../components/RenderBook.vue";
import BookController from "../controllers/BookController";
export default {
  name: "PaginatedBook",
  components: { RenderBook },
  data() {
    return {
      books: [],
      last_page: 5,
      current_page: 1,
      isLoading: false,
    };
  },
  computed: {
    isDisabledNext() {
      return this.current_page === this.last_page;
    },
    isDisabledPrev() {
      return this.current_page === 1;
    },
  },
  methods: {
    async fetchBooks() {
      this.isLoading = true;
      const response = await BookController.searchBook({
        page: this.current_page,
      });
      if (response) {
        this.books = response.data;
        this.current_page = response.current_page;
        this.last_page = response.last_page;
      }

      this.isLoading = false;
    },
    previous() {
      if (this.isDisabledPrev) return;
      this.current_page--;
    },
    next() {
      if (this.isDisabledNext) return;
      this.current_page++;
    },
    changePage(page) {
      this.current_page = page;
    },
  },
  watch: {
    current_page(newVal) {
      this.fetchBooks();
    },
  },
  mounted() {
    this.fetchBooks(this.current_page);
  },
};
</script>
