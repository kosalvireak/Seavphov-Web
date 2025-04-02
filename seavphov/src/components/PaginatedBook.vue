<template>
  <div>
    <RenderBook :books="books" :loading="isLoading" />
    <div
      v-if="!isLoading && books.length"
      class="pagination d-flex align-items-center justify-content-center  h-3rem mt-4"
    >
      <p
        @click="previous()"
        :disabled="isDisabledPrev"
        :class="{ '!cursor-not-allowed': isDisabledPrev || isLoading }"
      >
        &laquo;
      </p>
      <p
        v-for="page in last_page"
        :key="page"
        :class="[
          page == current_page ? 'active' : '',
          { '!cursor-not-allowed': isLoading },
        ]"
        @click="changePage(page)"
      >
        {{ page }}
      </p>
      <p
        @click="next()"
        :disabled="isDisabledNext"
        :class="{ '!cursor-not-allowed': isDisabledNext || isLoading }"
      >
        &raquo;
      </p>
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
      const response = await BookController.getBooksWithFilter(
        {
          page: this.current_page,
        },
        true,
      );
      if (response){
        this.books = response;
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

<style scoped>
.pagination {
  display: inline-block;
}

.pagination p {
  color: black;
  padding: 0.5rem 1rem;
  text-decoration: none;
  cursor: pointer;
}

.pagination p.active {
  background-color: #5c836e;
  color: white;
  border-radius: 5px;
}

.pagination p:hover:not(.active) {
  background-color: rgba(56, 151, 83, 0.388);
  border-radius: 5px;
}
</style>
