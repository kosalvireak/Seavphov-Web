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

    <div class="d-flex justify-content-end space-x-2">
      <div class="flex-center w-fit min-w-16 ring-1 ring-gray-200 rounded-lg">
        <Loader v-if="isLoadingDislike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="dislikeReview(review.id)"
        >
          Not Helpful: {{ review.not_helpful_vote }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16 ring-1 ring-gray-200 rounded-lg">
        <Loader v-if="isLoadingLike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="likeReview(review.id)"
        >
          Helpful:
          {{ review.helpful_vote }}
        </span>
      </div>
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
  data() {
    return {
      isLoadingLike: false,
      isLoadingDislike: false,
    };
  },
  methods: {
    async likeReview(id) {
      this.isLoadingLike = true;
      const data = await this.$store.dispatch("likeReview", id);
      if (data) {
        this.review.helpful_vote = data.helpful_vote;
      }

      this.isLoadingLike = false;
    },
    async dislikeReview(id) {
      this.isLoadingDislike = true;
      const data = await this.$store.dispatch("dislikeReview", id);
      if (data) {
        this.review.not_helpful_vote = data.not_helpful_vote;
      }
      this.isLoadingDislike = false;
    },
  },
};
</script>

<style></style>
