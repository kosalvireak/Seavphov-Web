<template>
  <div class="MyDiscussion w-100 h-auto">
    <div
      v-if="isLoading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader :size="40" />
    </div>
    <div v-else>
      <div v-if="!isEmpty">
        <div
          class="d-flex align-items-center justify-content-start m-1 mt-4"
          style="height: 40px"
        >
          <h6 class="p-0 m-0 font-bold font-75">
            Result: {{ discussions.length }} Discussions
          </h6>
        </div>
        <div class="flex-center">
          <div class="w-full lg:w-1/2 space-y-6">
            <DiscussionItem
              v-for="discussion in discussions"
              :key="discussion"
              :discussion="discussion"
            />
          </div>
        </div>
      </div>
      <SearchEmptyState v-else text="discussion" />
    </div>
  </div>
</template>

<script>
import DiscussionController from "../../controllers/DiscussionController";
import DiscussionItem from "../discussion/DiscussionItem.vue";
export default {
  name: "RenderMyBook",
  components: { DiscussionItem },
  props: ["uuid"],
  data() {
    return {
      discussions: [],
      isLoading: false,
    };
  },
  computed: {
    isEmpty() {
      return this.discussions.length == 0;
    },
  },
  async mounted() {
    this.isLoading = true;
    let filters = { uuid: null };
    filters.uuid = this.uuid;
    this.discussions = await DiscussionController.getDiscussionsWithFilter(
      filters
    );
    this.isLoading = false;
  },
};
</script>
<style scoped>
@media only screen and (max-width: 576px) {
  .font-75 {
    font-size: 75%;
  }
}
</style>
