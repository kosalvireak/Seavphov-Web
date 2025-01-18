<template>
  <section class="Discussion grid grid-cols-12 gap-4 w-100">
    <AdsContainer class="bg-gray-400" />
    <div class="col-span-12 lg:col-span-6 mt-4 space-y-6">
      <AddDiscussionContainer @on-add-discussion="onAddDiscussion" />
      <div class="flex-center w-100 h-44" v-if="isLoading">
        <Loader :size="40" />
      </div>
      <DiscussionItem
        v-for="discussion in discussions"
        :key="discussion"
        :discussion="discussion"
      />
    </div>
    <AdsContainer class="bg-green-400" />
  </section>
</template>

<script>
import AdsContainer from "../components/discussion/AdsContainer.vue";
import AddDiscussionContainer from "../components/discussion/AddDiscussionContainer.vue";
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
export default {
  name: "Discussion",
  components: { DiscussionItem, AddDiscussionContainer, AdsContainer },
  data() {
    return {
      discussions: [],
      isLoading: false,
    };
  },
  methods: {
    onAddDiscussion(response) {
      this.discussions.unshift(response);
    },
    async fetchDiscussions() {
      this.isLoading = true;
      const response = await this.$store.dispatch("fetchDiscussions");
      this.isLoading = false;
      this.discussions = response;
    },
  },
  mounted() {
    this.fetchDiscussions();
  },
};
</script>
<style scoped>
.Discussion {
  min-height: 100vh;
}
</style>
