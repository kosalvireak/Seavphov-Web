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
          class="d-flex align-items-center justify-content-end m-1 mt-4"
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
      <div v-else class="h-100 w-100">
        <div
          class="h-auto d-flex flex-column justify-content-center align-items-center m-5"
        >
          <img
            src="/img/notfound.png"
            alt="not found"
            class="w-25 img-fluid mb-3 rounded rounded-7"
          />
          <h3>No discussions found...!</h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DiscussionController from "../../controllers/DiscussionController";
import DiscussionItem from "../discussion/DiscussionItem.vue";
export default {
  name: "RenderMyBook",
  components: { DiscussionItem },
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
    this.discussions = await DiscussionController.getMyDiscussions();
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
