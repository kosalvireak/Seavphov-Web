<template>
  <section
    class="CommentItem container w-100 mb-4 rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Comment header -->
    <a
      :href="`/profile/${comment.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100 space-x-2"
    >
      <img class="sp-logo-sm rounded-full" :src="comment.user[0].picture" />
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
    <div class="Reaction d-flex space-x-2 w-fit ml-auto">
      <div class="flex-center w-fit min-w-16 rounded-lg">
        <Loader v-if="isLoadingDislike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="dislike(comment.id)"
        >
          <i
            class="fa-regular fa-thumbs-down fa-xl"
            :class="{
              'fa-solid': comment.reaction != null && !comment.reaction,
            }"
          ></i>
          {{ comment.dislike }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16 rounded-lg">
        <Loader v-if="isLoadingLike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100 bg-yellow"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="like(comment.id)"
        >
          <i
            class="fa-regular fa-thumbs-up fa-xl"
            :class="{
              'fa-solid': comment.reaction != null && comment.reaction,
            }"
          ></i>
          {{ comment.like }}
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
    };
  },
  methods: {
    async like(id) {
      this.isLoadingLike = true;
      const data = await this.$store.dispatch("likeComment", id);
      if (data) {
        this.comment.like = data.like;
        this.comment.dislike = data.dislike;
        this.comment.reaction = data.reaction;
      }
      this.isLoadingLike = false;
    },
    async dislike(id) {
      this.isLoadingDislike = true;
      const data = await this.$store.dispatch("dislikeComment", id);
      if (data) {
        this.comment.like = data.like;
        this.comment.dislike = data.dislike;
        this.comment.reaction = data.reaction;
      }
      this.isLoadingDislike = false;
    },
  },
};
</script>

<style></style>
