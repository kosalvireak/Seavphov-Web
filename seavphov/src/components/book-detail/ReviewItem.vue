<template>
  <section
    class="ReviewItem container-xl w-100 rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Review header -->
    <a
      :href="`/profile/${review.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-fit"
    >
      <img class="sp-logo-sm rounded-full mr-2" :src="review.user[0].picture" />
      <p class="m-0 text-sp-dark">{{ review.user[0].name }}</p>
    </a>

    <!-- Review Date -->
    <p class="text-xs text-sp-gray">
      Reviewed on {{ formatDate(review.created_at) }}
    </p>

    <!-- Review delete Button -->
    <ReviewItemDropdown
      v-if="review.delete_able || review.edit_able"
      :id="review.id"
      :review="review"
      @on-remove-review="$emit('onRemoveReview', $event)"
      @on-edit="isEditing = true"
    />

    <EditReview
      v-if="isEditing"
      :review="review"
      @on-finish-editing="isEditing = false"
    />

    <section v-else>
      <div class="w-100 min-h-12 border border-gray-100 rounded-lg p-2 my-2">
        {{ review.body }}
      </div>

      <Reaction
        :entity="review"
        likeMethodName="likeReview"
        dislikeMethodName="dislikeReview"
      />
    </section>
  </section>
</template>

<script>
import EditReview from "./EditReview.vue";
import ReviewItemDropdown from "./ReviewItemDropdown.vue";
import { MDBTextarea } from "mdb-vue-ui-kit";
import Reaction from "../common/Reaction.vue";
export default {
  name: "ReviewItem",
  components: { MDBTextarea, ReviewItemDropdown, Reaction, EditReview },
  props: {
    review: Object,
  },
  data() {
    return {
      isEditing: false,
    };
  },
};
</script>

<style></style>
