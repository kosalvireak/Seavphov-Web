<template>
  <section class="Discussion grid grid-cols-12 gap-4 w-100">
    <div class="col-span-3 bg-gray-400">Left</div>
    <div class="col-span-12 lg:col-span-6 mt-4 space-y-6">
      <AddDiscussionContainer @on-add-discussion="onAddDiscussion" />
      <div class="flex-center w-100 h-44" v-if="isLoading">
        <Loader :size="40" />
      </div>
      <DiscussionItem
        v-for="discussion in discussions"
        :key="discussion"
        :data="discussion"
      />
    </div>
    <div class="col-span-3 bg-green-400">Right</div>
  </section>
</template>

<script>
import AddDiscussionContainer from "../components/discussion/AddDiscussionContainer.vue";
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
export default {
  name: "Discussion",
  components: { DiscussionItem, AddDiscussionContainer },
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