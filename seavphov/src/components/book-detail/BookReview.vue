<template>
  <section class="BookReview space-y-2">
    <h5 class="font-bold text-black">Reviews</h5>
    <AddReview :book_id="book_id" @on-add-review="onAddReview($event)" />
    <ReviewItem
      v-for="review in reviews"
      :key="review.id"
      :review="review"
      @on-remove="onReviewReview($event)"
    />
    <div v-if="isLoading" class="w-100 h-24 flex-center">
      <Loader :size="30" />
    </div>
  </section>
</template>

<script>
import Loader from "../common/Loader.vue";
import AddReview from "./AddReview.vue";
import ReviewItem from "./ReviewItem.vue";

export default {
  name: "BookReview",
  components: { AddReview, ReviewItem, Loader },
  props: {
    book_id: {
      type: [Number, String],
    },
  },
  data() {
    return {
      reviews: [],
      isLoading: false,
    };
  },
  methods: {
    onAddReview(review) {
      this.reviews.push(review);
    },
    onReviewReview(id) {
      this.reviews = this.reviews.filter((review) => review.id !== id);
    },
  },
  watch: {
    book_id: {
      immediate: true,
      async handler() {
        if (this.book_id === undefined) return;
        this.isLoading = true;
        this.reviews = await this.$store.dispatch(
          "fetchBookReviews",
          this.book_id,
        );
        this.isLoading = false;
      },
    },
  },
};
</script>

<style></style>
