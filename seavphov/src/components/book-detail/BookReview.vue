<template>
  <section class="BookReview">
    <h5 class="font-bold text-black">Reviews</h5>
    <AddReview />
    <ReviewItem />
  </section>
</template>

<script>
import AddReview from "./AddReview.vue";
import ReviewItem from "./ReviewItem.vue";

export default {
  name: "BookReview",
  components: { AddReview, ReviewItem },
};
</script>

<style>
</style>