<template>
  <div class="NewestAddition container w-100 h-auto p-4 rounded-lg space-y-4">
    <div class="h-10 d-flex align-items-center justify-content-start">
      <h3 class="p-0 m-0 fw-bold font-50">Newest addition!</h3>
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
  mounted() {
    this.isLoading = true;
    this.$store.dispatch("fetchNewestAddition").then((response) => {
      this.books = response;
      this.isLoading = false;
    });
  },
};
</script>

<style></style>
