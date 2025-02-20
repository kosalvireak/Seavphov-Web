<template>
  <section
    class="CommentItem container w-100 mb-4 rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Comment header -->
    <a
      :href="`/profile/${comment.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100 space-x-2"
    >
      <img class="sp-logo-md rounded-full" :src="comment.user[0].picture" />
      <div class="flex-col">
        <p class="m-0 text-sp-dark">{{ comment.user[0].name }}</p>

        <!-- Comment Date -->
        <p class="text-xs text-sp-gray m-0">
          commented on {{ formatDate(comment.created_at) }}
        </p>
      </div>
    </a>

    <!-- Comment delete Button -->
    <CommentItemDropdown
      v-if="comment.delete_able"
      :id="comment.id"
      @on-remove="$emit('onRemove', $event)"
    />

    <div class="w-100 min-h-12 m-2">
      {{ comment.body }}
    </div>

    <div class="d-flex justify-content-start space-x-2">
      <div class="flex-center w-fit min-w-16 mr-1">
        <Loader v-if="isLoadingLike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-1 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="voteCommentHelpful(comment.id)"
        >
          <i class="fa-regular fa-thumbs-up fa-xl"></i>
          {{ comment.helpful_vote }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16">
        <Loader v-if="isLoadingDislike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-1 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="voteCommentNotHelpful(comment.id)"
        >
          <i class="fa-regular fa-thumbs-down fa-xl"></i>
          {{ comment.not_helpful_vote }}
        </span>
      </div>
    </div>
  </section>
</template>

<script>
import { MDBTextarea } from "mdb-vue-ui-kit";
import CommentItemDropdown from "./CommentItemDropdown.vue";
export default {
  name: "CommentItem",
  components: { MDBTextarea, CommentItemDropdown },
  props: {
    comment: Object,
  },
  data() {
    return {
      isLoadingLike: false,
      isLoadingDislike: false,
      isDeleting: false,
    };
  },
  methods: {
    async voteCommentHelpful(id) {
      this.isLoadingLike = true;
      const data = await this.$store.dispatch("voteCommentHelpful", id);
      if (data) {
        this.comment.helpful_vote = data.helpful_vote;
      }
      this.isLoadingLike = false;
    },
    async voteCommentNotHelpful(id) {
      this.isLoadingDislike = true;
      const data = await this.$store.dispatch("voteCommentNotHelpful", id);
      if (data) {
        this.comment.not_helpful_vote = data.not_helpful_vote;
      }
      this.isLoadingDislike = false;
    },
    async deleteComment(id) {
      this.isDeleting = true;
      const response = await this.$store.dispatch("deleteComment", id);
      if (response) {
        this.$emit("onRemove", id);
      }
      this.isDeleting = false;
    },
  },
};
</script>

<style></style>
