<template>
  <RenderBook :hideHeader="true" :books="userBooks" :loading="isLoading" />
</template>

<script>
import RenderBook from "../RenderBook.vue";
import BookController from "../../controllers/BookController";
export default {
  name: "RenderUserBook",
  components: {
    RenderBook,
  },
  props: {
    uuid: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      userBooks: [],
      isLoading: false,
    };
  },
  async mounted() {
    this.isLoading = true;
    let filters = { uuid: "12" };
    filters.uuid = this.uuid;
    this.userBooks = await BookController.getBooksWithFilter(filters);
    this.isLoading = false;
  },
};
</script>

<style></style>
