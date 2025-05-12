<template>
  <div class="space-y-6 container-xl h-100 flex justify-start flex-column">
    <p class="h4 mb-none">Newest Discussions</p>

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
  name: "NewestDiscussions",
  components: { DiscussionItem, DiscussionWidgetItem },
  data() {
    return {
      discussions: [],
      isLoading: false,
    };
  },
  methods: {
    async fetchDiscussions() {
      this.isLoading = true;
      const response = await DiscussionController.getDiscussionsWithFilter({});
      this.discussions = response.slice(0, 3);
      this.isLoading = false;
    },
  },
  mounted() {
    this.fetchDiscussions();
  },
};
</script>

<style></style>
