<template>
  <section class="RenderUserBook">
    <RenderBook :hideHeader="true" :books="userBooks" :loading="isLoading" />
  </section>
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
  methods: {
    async getSearchBookByUuid() {
      this.isLoading = true;
      let filters = { uuid: "" };
      filters.uuid = this.uuid;
      const response = await BookController.searchBook(filters);
      this.userBooks = response.data;
      this.isLoading = false;
    },
  },
  async mounted() {
    await this.getSearchBookByUuid();
  },
};
</script>

<style></style>
