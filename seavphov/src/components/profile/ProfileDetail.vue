<template>
  <component v-if="selectedComponent" :is="selectedComponent" />
</template>

<script>
import MySavedBooks from "./MySavedBooks.vue";
import RenderMyBook from "./RenderMyBook.vue";
import MyDiscussion from "./MyDiscussions.vue";
import MyReviews from "./MyReviews.vue";
export default {
  name: "ProfileDetail",
  components: {
    MySavedBooks,
    RenderMyBook,
    MyDiscussion,
    MyReviews,
  },
  props: {
    page: {
      type: String,
      default: "my-books",
    },
  },
  data() {
    return {
      selectedComponent: null,
    };
  },
  watch: {
    page: {
      immediate: true,
      async handler() {
        if (this.page === undefined) return;
        switch (this.page) {
          case "my-books":
            this.selectedComponent = "RenderMyBook";
            break;
          case "savedbooks":
            this.selectedComponent = "MySavedBooks";
            break;
          case "my-discussions":
            this.selectedComponent = "MyDiscussion";
            break;
          case "my-reviews":
            this.selectedComponent = "MyReviews";
            break;
          case "my-comments":
            this.selectedComponent = "MySavedBooks";
            break;

          // view user profile
          case "books":
            this.selectedComponent = "RenderUserBook";
            break;
          case "discussions":
            this.selectedComponent = "RenderUserDiscussion";
            break;
        }
      },
    },
  },
};
</script>

<style>
</style>