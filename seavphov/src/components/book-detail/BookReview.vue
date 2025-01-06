<template>
  <section class="BookReview space-y-2">
    <h5 class="font-bold text-black">Reviews</h5>
    <AddReview :book_id="book_id" @on-add-review="reviews.push($event)" />
    <ReviewItem v-for="review in reviews" :key="review.id" :review="review" />
  </section>
</template>

<script>
import AddReview from "./AddReview.vue";
import ReviewItem from "./ReviewItem.vue";

export default {
  name: "BookReview",
  components: { AddReview, ReviewItem },
  props: { book_id: Number },
  data() {
    return {
      reviews: [],
    };
  },
  watch: {
    book_id: {
      immediate: true,
      async handler() {
        if (this.book_id === undefined) return;
        this.reviews = await this.$store.dispatch(
          "fetchBookReviews",
          this.book_id,
        );
      },
    },
  },
};
</script>

<style></style>
