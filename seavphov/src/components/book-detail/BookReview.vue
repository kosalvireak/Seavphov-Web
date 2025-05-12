<template>
  <section class="BookReview space-y-4">
    <p class="h5">Reviews</p>
    <AddReview :book_id="book_id" @on-add-review="onAddReview($event)" />
    <ReviewItem
      v-for="review in reviews"
      :key="review.id"
      :review="review"
      @on-remove-review="onRemoveReview($event)"
    />
    <div v-if="isLoading" class="w-100 h-24 flex-center">
      <Loader :size="30" />
    </div>
  </section>
</template>

<script>
import ReviewController from "../../controllers/ReviewController";
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
    onRemoveReview(id) {
      this.reviews = this.reviews.filter((review) => review.id !== id);
    },
    onAddReview(review) {
      if (!this.reviews) {
        this.reviews.push(review);
      } else {
        this.reviews.unshift(review);
      }
    },
  },
  watch: {
    book_id: {
      immediate: true,
      async handler() {
        if (this.book_id === undefined) return;
        this.isLoading = true;
        this.reviews = await ReviewController.getReviewsOfBook(this.book_id);
        this.isLoading = false;
      },
    },
  },
};
</script>

<style></style>
