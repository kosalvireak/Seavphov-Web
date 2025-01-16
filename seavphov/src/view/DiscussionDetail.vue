<template>
  <section class="DiscussionDetail grid grid-cols-12 gap-4 w-100">
    <div class="col-span-3 bg-gray-400">Left</div>
    <div class="col-span-12 lg:col-span-6 mt-4 space-y-6">
      <div class="flex-center w-100 h-44" v-if="isLoading">
        <Loader :size="40" />
      </div>
      <DiscussionItem :data="discussion" />
    </div>
    <div class="col-span-3 bg-green-400">Right</div>
  </section>
</template>

<script>
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
export default {
  name: "DiscussionDetail",
  components: { DiscussionItem },
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
