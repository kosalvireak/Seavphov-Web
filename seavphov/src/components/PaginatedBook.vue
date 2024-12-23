<template>
  <div>
    <RenderBook :books="books" :loading="isLoading" />
    <div
      class="d-flex align-items-center justify-content-center pagination h-3rem mt-4"
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
import axios from "axios";
export default {
  name: "PaginatedBook",
  components: { RenderBook },
  data() {
    return {
      books: [],
      last_page: 5,
      current_page: 1,
      path: import.meta.env.VITE_BACKEND_URL + "/api/books?page=",
      isLoading: false,
    };
  },
  computed: {
    isDisabledNext() {
      return this.current_page == this.last_page;
    },
    isDisabledPrev() {
      return this.current_page == 1;
    },
  },
  methods: {
    async fetchBooks(path) {
      try {
        this.isLoading = true;
        const response = await axios.get(path);
        if (response.data.success) {
          this.books = response.data.message.data;
          this.current_page = response.data.message.current_page;
          this.last_page = response.data.message.last_page;
        }
        this.isLoading = false;
      } catch (error) {
        this.$toast.error(error.response.data.message);
      }
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
    current_page(newVal, oldVal) {
      this.fetchBooks(this.path + newVal);
    },
  },
  mounted() {
    this.fetchBooks(this.path + this.current_page);
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
  background-color: #4caf50;
  color: white;
  border-radius: 5px;
}

.pagination p:hover:not(.active) {
  background-color: rgba(56, 151, 83, 0.388);
  border-radius: 5px;
}
</style>
