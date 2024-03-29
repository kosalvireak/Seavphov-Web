<template>
  <div>
    <RenderBook :books="books" />
    <div
      class="d-flex align-items-center justify-content-center pagination h-3rem m-2"
    >
      <a
        @click="previous()"
        :disabled="isDisabledPrev"
        :class="{ 'pe-none': isDisabledPrev }"
        >&laquo;</a
      >
      <a
        v-for="page in last_page"
        :key="page"
        :class="[page == current_page ? 'active' : '']"
        @click="changePage(page)"
      >
        {{ page }}
      </a>
      <a
        @click="next()"
        :disabled="isDisabledNext"
        :class="{ 'pe-none': isDisabledNext }"
        >&raquo;</a
      >
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
      await axios.get(path).then((response) => {
        this.books = response.data.data;
        this.current_page = response.data.current_page;
        this.last_page = response.data.last_page;
      });
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

<style>
.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 0.5rem 1rem;
  text-decoration: none;
}

.pagination a.active {
  background-color: #4caf50;
  color: white;
  border-radius: 5px;
}

.pagination a:hover:not(.active) {
  background-color: rgba(56, 151, 83, 0.388);
  border-radius: 5px;
}
</style>