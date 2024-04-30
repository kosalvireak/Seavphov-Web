<template>
  <div class="RenderMyBook w-100 h-auto">
    <div
      v-if="loading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader />
    </div>
    <div v-else>
      <div v-if="!isBooksEmpty">
        <div
          class="d-flex align-items-center justify-content-end m-1"
          style="height: 40px"
        >
          <h6 class="p-0 m-0 fw-bold">Result: {{ books.length }} Books</h6>
        </div>
        <div v-for="book in books" :key="book.id">
          <MyBook :book="book" :key="book.id" class="m-0 p-0" />
        </div>
      </div>
      <div v-else class="h-100 w-100">
        <div
          class="d-flex align-items-center justify-content-end m-1"
          style="height: 40px"
        >
          <h6 class="p-0 m-0 fw-bold">Result: {{ books.length }} Book</h6>
        </div>
        <div
          class="h-auto d-flex flex-column justify-content-center align-items-center m-5"
        >
          <img
            src="/img/notfound.png"
            alt="not found"
            class="w-25 img-fluid mb-3 rounded rounded-7"
          />
          <h3>No books found...!</h3>
        </div>
      </div>
    </div>
  </div>
</template>
    
    <script>
import MyBook from "./MyBook.vue";
import Loader from "./Loader.vue";

export default {
  name: "RenderMyBook",
  components: { MyBook, Loader },
  props: { books: Array, loading: Boolean },
  computed: {
    isBooksEmpty() {
      if (this.books & (this.books.length == 0)) {
        return true;
      } else {
        return false;
      }
    },
  },
};
</script>