<template>
  <div class="space-y-4 container-xl h-100 flex justify-start flex-column">
    <p class="h4 mb-0">Popular Discussions</p>

    <div class="flex-center w-100 h-40" v-if="isLoading">
      <Loader :size="40" />
    </div>

    <DiscussionWidgetItem
      v-else
      v-for="discussion in discussions"
      :key="discussion"
      :discussion="discussion"
    />
  </div>
</template>

<script>
import DiscussionWidgetItem from "./DiscussionWidgetItem.vue";
import DiscussionController from "../../controllers/DiscussionController.js";
import DiscussionItem from "./DiscussionItem.vue";

export default {
  name: "PopularDiscussion",
  components: { DiscussionItem, DiscussionWidgetItem },
  data() {
    return {
      discussions: [],
      isLoading: false,
    };
  },
  async mounted() {
    this.isLoading = true;
    this.discussions = await DiscussionController.getPopularDiscussion();
    this.isLoading = false;
  },
};
</script>

<style></style>
