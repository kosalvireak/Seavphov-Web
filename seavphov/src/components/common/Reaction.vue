<template>
  <div class="Reaction d-flex space-x-2 w-fit ml-auto">
    <div class="flex-center w-fit min-w-16 rounded-lg">
      <Loader v-if="isLoadingDislike" />
      <span
        v-else
        class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100"
        :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
        @click="dislike(entity.id)"
      >
        <i
          class="fa-regular fa-thumbs-down fa-xl"
          :class="{ 'fa-solid': entity.reaction != null && !entity.reaction }"
        ></i>
        {{ entity.dislike }}
      </span>
    </div>
    <div class="flex-center w-fit min-w-16 rounded-lg">
      <Loader v-if="isLoadingLike" />
      <span
        v-else
        class="clickable hover:bg-gray-200 px-2 py-1 rounded-lg text-md h-100 bg-yellow"
        :class="{ '!cursor-not-allowed hover:bg-white': !isLogin }"
        @click="like(entity.id)"
      >
        <i
          class="fa-regular fa-thumbs-up fa-xl"
          :class="{ 'fa-solid': entity.reaction != null && entity.reaction }"
        ></i>
        {{ entity.like }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "Reaction",
  data() {
    return {
      isLoadingLike: false,
      isLoadingDislike: false,
    };
  },
  props: {
    entity: Object,
  },
  methods: {
    async like(id) {
      this.isLoadingLike = true;
      const data = await this.$store.dispatch("likeReview", id);
      if (data) {
        this.entity.like = data.like;
        this.entity.dislike = data.dislike;
        this.entity.reaction = data.reaction;
      }
      this.isLoadingLike = false;
    },
    async dislike(id) {
      this.isLoadingDislike = true;
      const data = await this.$store.dispatch("dislikeReview", id);
      if (data) {
        this.entity.like = data.like;
        this.entity.dislike = data.dislike;
        this.entity.reaction = data.reaction;
      }
      this.isLoadingDislike = false;
    },
  },
};
</script>

<style>
</style>