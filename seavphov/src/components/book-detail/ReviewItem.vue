<template>
  <section
    class="ReviewItem container w-100 rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Review header -->
    <a
      :href="`/profile/${review.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-fit"
    >
      <img class="sp-logo-sm rounded-full mr-2" :src="review.user[0].picture" />
      <p class="m-0 text-sp-dark">{{ review.user[0].name }}</p>
    </a>

    <!-- Review delete Button -->
    <ReviewItemDropdown
      v-if="review.delete_able"
      :id="review.id"
      @on-remove="$emit('onRemove', $event)"
    />

    <!-- Review Date -->
    <p class="text-xs text-sp-gray">
      Reviewed on {{ formatDate(review.created_at) }}
    </p>
    <div class="w-100 min-h-12 border border-gray-100 rounded-lg p-2">
      {{ review.body }}
    </div>

    <Reaction :entity="review" />
  </section>
</template>

<script>
import ReviewItemDropdown from "./ReviewItemDropdown.vue";
import { MDBTextarea } from "mdb-vue-ui-kit";
import Reaction from "../common/Reaction.vue";
export default {
  name: "ReviewItem",
  components: { MDBTextarea, ReviewItemDropdown, Reaction },
  props: {
    review: Object,
  },
  data() {
    return {
      isDeleting: false,
    };
  },
};
</script>

<style></style>
