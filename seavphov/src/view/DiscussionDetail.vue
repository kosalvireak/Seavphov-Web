<template>
  <section class="DiscussionDetail min-h-screen grid grid-cols-12 gap-4 w-100">
    <AdsContainer class="bg-gray-400" />
    <div class="col-span-12 lg:col-span-6 mt-4 space-y-6 container">
      <BackRoute />
      <div class="flex-center w-100 h-44" v-if="isLoading">
        <Loader :size="40" />
      </div>
      <DiscussionItem :discussion="discussion" />
      <CommentSection :discussion_id="paramsId" />
    </div>
    <AdsContainer class="bg-green-400" />
  </section>
</template>

<script>
import AdsContainer from "../components/discussion/AdsContainer.vue";
import CommentSection from "../components/discussion/CommentSection.vue";
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
export default {
  name: "DiscussionDetail",
  components: { DiscussionItem, CommentSection, AdsContainer },
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
    async getDiscussion(id) {
      this.isLoading = true;
      const response = await this.$store.dispatch("fetchDiscussionById", id);
      this.discussion = response;
      this.isLoading = false;
    },
  },
  async created() {
    await this.getDiscussion(this.paramsId);
  },
};
</script>

<style></style>
