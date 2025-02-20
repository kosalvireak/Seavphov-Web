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

    <div class="d-flex justify-content-end space-x-2">
      <div class="flex-center w-fit min-w-16 rounded-lg">
        <Loader v-if="isLoadingDislike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="dislikeReview(review.id)"
        >
          <i class="fa-regular fa-thumbs-down fa-xl"></i>
          {{ review.dislike }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16 rounded-lg">
        <Loader v-if="isLoadingLike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100 bg-yellow"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="likeReview(review.id)"
        >
          <i class="fa-regular fa-thumbs-up fa-xl"></i>
          {{ review.like }}
        </span>
      </div>
    </div>
  </section>
</template>

<script>
import ReviewItemDropdown from "./ReviewItemDropdown.vue";
import { MDBTextarea } from "mdb-vue-ui-kit";
export default {
  name: "ReviewItem",
  components: { MDBTextarea, ReviewItemDropdown },
  props: {
    review: Object,
  },
  data() {
    return {
      isLoadingLike: false,
      isLoadingDislike: false,
      isDeleting: false,
    };
  },
  methods: {
    async likeReview(id) {
      this.isLoadingLike = true;
      const data = await this.$store.dispatch("likeReview", id);
      if (data) {
        // this.review.like = data.like;
        console.table(data);
      }
      this.isLoadingLike = false;
    },
    async dislikeReview(id) {
      this.isLoadingDislike = true;
      const data = await this.$store.dispatch("dislikeReview", id);
      if (data) {
        // this.review.dislike = data.dislike;
        console.table(data);
      }
      this.isLoadingDislike = false;
    },
  },
};
</script>

<style></style>
