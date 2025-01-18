<template>
  <section class="Discussion grid grid-cols-12 gap-4 w-100">
    <div class="col-span-3 ml-5 mt-4 justify-center align-item-center">
      <img src="https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/Poster-1.jpg" class="w-full h-25">
      </div>
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
    <div class="col-span-3 mr-5 mt-4">
      <img src="https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/Poster-2.jpg" class="w-full h-25">
      </div>
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
