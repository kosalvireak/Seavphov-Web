<template>
  <section class="BookReview space-y-2">
    <h5 class="font-bold text-black">Reviews</h5>
    <AddReview :book_id="book_id" />
    <ReviewItem />
    <ReviewItem />
  </section>
</template>

<script>
import AddReview from "./AddReview.vue";
import ReviewItem from "./ReviewItem.vue";

export default {
  name: "BookReview",
  components: { AddReview, ReviewItem },
  props: { book_id: Number },
};
</script>

<style>
</style>