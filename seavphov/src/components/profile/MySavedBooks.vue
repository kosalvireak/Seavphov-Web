<template>
  <RenderBook :hideHeader="true" :books="savedBooks" :loading="isLoading" />
</template>

<script>
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

    this.savedBooks = await this.$store.dispatch("fetchSavedBook");
    this.isLoading = false;
  },
};
</script>

<style>
</style>