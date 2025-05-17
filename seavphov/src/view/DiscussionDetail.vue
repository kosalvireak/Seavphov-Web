<template>
  <section class="DiscussionDetail min-h-screen grid grid-cols-12 gap-4 w-100">
    <div class="col-span-12 lg:col-span-9 my-4 space-y-6 container-xl">
      <BackRoute route="discussion" />
      <div class="flex-center w-100 h-44" v-if="isLoading">
        <Loader :size="40" />
      </div>
      <template v-else>
        <DiscussionItem :discussion="discussion" />
        <CommentSection :discussion_id="paramsId" />
      </template>
    </div>
    <NewestDiscussions class="col-span-12 lg:col-span-3 mt-4" />
  </section>
</template>

<script>
import NewestDiscussions from "../components/discussion/NewestDiscussions.vue";
import CommentSection from "../components/discussion/CommentSection.vue";
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
import DiscussionController from "../controllers/DiscussionController";
export default {
  name: "DiscussionDetail",
  components: {
    DiscussionItem,
    CommentSection,
    NewestDiscussions: NewestDiscussions,
  },
  data() {
    return {
      discussion: {},
      isLoading: false,
    };
  },
  computed: {
    paramsId() {
      return this.$route.params.id;
    },
  },
  methods: {
    async getDiscussionById(id) {
      this.isLoading = true;
      this.discussion = await DiscussionController.getDiscussionById(id);
      this.isLoading = false;
    },
  },
  async created() {
    await this.getDiscussionById(this.paramsId);
  },
};
</script>

<style></style>
