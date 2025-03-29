<template>
  <RenderBook :hideHeader="true" :books="savedBooks" :loading="isLoading" />
</template>

<script>
import BookController from "../../controllers/BookController";
import RenderBook from "../RenderBook.vue";
export default {
  name: "MySavedBooks",
  components: {
    RenderBook,
  },
  data() {
    return {
      savedBooks: [],
      isLoading: false,
    };
  },
  async mounted() {
    this.isLoading = true;
    this.savedBooks = await BookController.getSavedBook();
    this.isLoading = false;
  },
};
</script>

<style></style>
