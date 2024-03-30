<template>
  <div>
    <RenderBook :books="books" />
    <div
      class="d-flex align-items-center justify-content-center pagination h-3rem mt-4"
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
import { useToast } from "vue-toastification";
export default {
  name: "PaginatedBook",
  components: { RenderBook },
  data() {
    return {
      toast: useToast(),
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
      try {
        const response = await axios.get(path);
        if (response.data.success) {
          this.books = response.data.message.data;
          this.current_page = response.data.message.current_page;
          this.last_page = response.data.message.last_page;
        }
      } catch (error) {
        this.toast.error(error.response.data.message);
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