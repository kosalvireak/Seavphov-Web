<template>
  <section class="ReviewItem container w-100 border rounded-lg p-2 space-y-2">
    <a
      :href="`/profile/${review.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable"
    >
      <img class="sp-logo-sm rounded-full mr-2" :src="review.user[0].picture" />
      <p class="m-0 text-sp-dark">{{ review.user[0].name }}</p>
    </a>
    <p class="text-xs text-sp-gray">
      Reviewed on {{ formatDate(review.created_at) }}
    </p>
    <div class="w-100 min-h-12 border border-gray-100 rounded-lg p-2">
      {{ review.body }}
    </div>

    <div class="d-flex justify-content-end space-x-4">
      <span class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md">
        <i class="fa-regular fa-thumbs-down fa-xl mr-1"></i
        >{{ review.helpful_vote }}
      </span>
      <span class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md">
        <i class="fa-regular fa-thumbs-up fa-xl mr-1"></i>
        {{ review.not_helpful_vote }}
      </span>
    </div>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "ReviewItem",
  components: { MDBTextarea },
  props: {
    review: Object,
  },
};
</script>

<style>
</style>