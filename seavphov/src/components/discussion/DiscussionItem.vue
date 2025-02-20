<template>
  <section
    v-if="discussion.user"
    class="DiscussionItem container rounded-lg p-2 space-y-2 ring-1 ring-gray-300 relative"
  >
    <!-- Discussion header -->
    <a
      :href="`/profile/${discussion.user[0].uuid}`"
      class="d-flex justify-content-start align-items-center text-decoration-none clickable w-100"
    >
      <img
        class="sp-logo-md rounded-full m-2"
        :src="discussion.user[0].picture"
      />

      <div class="flex-col mt-3">
        <!-- User Name -->
        <p class="m-0 text-sp-dark">{{ discussion.user[0].name }}</p>

        <!-- Discussion Date -->
        <p class="text-xs text-sp-gray">
          posted on {{ formatDate(discussion.created_at) }}
        </p>
      </div>
    </a>

    <!-- Discussion delete Button -->
    <DiscussionItemDropdown
      v-if="discussion.delete_able"
      :id="discussion.id"
      class="absolute right-2 top-0"
    />

    <!-- Discussion Body -->
    <div class="w-100 ml-2">
      {{ discussion.body }}
      <span
        v-if="discussion.has_more_text"
        @click="toDiscussionDetail()"
        class="text-gray-400 text-sm italic clickable"
        >...see more</span
      >
    </div>
    <div class="w-100 max-h-72 flex-center">
      <img :src="discussion.image" class="max-h-64" alt="discussion image" />
    </div>
    <div class="d-flex justify-content-start space-x-2">
      <div class="flex-center w-fit min-w-16">
        <Loader v-if="isLoadingLike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-1 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="likeDiscussion()"
        >
          <i class="fa-regular fa-thumbs-up fa-xl"></i>
          {{ discussion.like }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16">
        <Loader v-if="isLoadingDislike" />
        <span
          v-else
          class="clickable hover:bg-gray-200 px-1 py-1 rounded-lg text-md h-100"
          :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
          @click="dislikeDiscussion()"
        >
          <i class="fa-regular fa-thumbs-down fa-xl"></i>
          {{ discussion.dislike }}
        </span>
      </div>
      <div class="flex-center w-fit min-w-16 rounded-lg hover:bg-gray-200">
        <span
          class="clickable px-2 py-1 rounded-lg text-md h-100"
          @click="toDiscussionDetail()"
          ><i class="fa fa-commenting fa-xl" aria-hidden="true"> </i>
          {{ discussion.number_of_comments }}
        </span>
      </div>
    </div>
  </section>
</template>

<script>
import DiscussionItemDropdown from "./DiscussionItemDropdown.vue";
export default {
  name: "DiscussionItem",
  components: { DiscussionItemDropdown },
  props: {
    discussion: Object,
  },
  data() {
    return {
      isDeleting: false,
      isLoadingLike: false,
      isLoadingDislike: false,
    };
  },
  methods: {
    toDiscussionDetail() {
      this.toRouteName("discussion-detail", this.discussion.id);
    },

    async likeDiscussion() {
      this.isLoadingLike = true;
      const data = await this.$store.dispatch(
        "likeDiscussion",
        this.discussion.id
      );
      if (data) {
        this.discussion.like = data.like;
      }
      this.isLoadingLike = false;
    },
    async dislikeDiscussion(id) {
      this.isLoadingDislike = true;
      const data = await this.$store.dispatch(
        "dislikeDiscussion",
        this.discussion.id
      );
      if (data) {
        this.discussion.dislike = data.dislike;
      }
      this.isLoadingDislike = false;
    },

    async deleteDiscussion() {
      this.isDeleting = true;
      const response = await this.$store.dispatch(
        "deleteDiscussion",
        this.discussion.id
      );
      this.toRouteName("discussions");
      this.isDeleting = false;
    },
  },
  // {
  //   "id": 1,
  //   "user": [
  //     {
  //       "name": "Kosal Vireak1",
  //       "picture": "https:\/\/firebasestorage.googleapis.com\/v0\/b\/seavphov-919d7.appspot.com\/o\/folder%2F1268992.jpg?alt=media&token=c863c8cd-f68c-4a87-b345-0e0014e29240",
  //       "uuid": "lSZWwmr5L9OvD8v3Xh95YMPRfAPjzo"
  //     }
  //   ],
  //   "body": "Good Logo yet?",
  //   "number_of_comments": 0,
  //   "like": 0,
  //   "dislike": 0,
  //   "delete_able": false,
  //   "created_at": "2025-01-15T16:25:20.000000Z"
  // }
};
</script>

<style></style>
