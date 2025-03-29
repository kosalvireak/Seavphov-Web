<template>
  <section class="Discussion">
    <HomeNavigation selectedTab="discussion" />
    <div class="grid grid-cols-12 w-full mb-6">
      <div
        class="col-span-12 lg:col-span-3 h-64 lg:h-96 sm:p-0 lg:p-6 justify-center align-item-center"
      >
        <img
          src="https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/Poster-1.jpg"
          class="w-full h-full object-cover"
        />
      </div>
      <div class="col-span-12 lg:col-span-6 mt-4 space-y-6 w-100">
        <form
          class="p-0 rounded-lg d-flex flex-row relative"
          v-on:submit.prevent="fetchDiscussions()"
        >
          <MDBInput
            type="text"
            label="Search discussion"
            id="title"
            v-model="keyword"
            wrapperClass="bg-white h-3rem"
          />
          <button
            type="submit"
            class="w-20 absolute right-0 p-2.5 text-sm font-medium h-full text-white bg-seavphov rounded border"
          >
            <i class="fa fa-magnifying-glass"></i>
          </button>
        </form>

        <!-- Create new discussion -->
        <AddDiscussionContainer
          @on-add-discussion="discussions.unshift($event)"
        />

        <div class="flex-center w-100 h-44" v-if="isLoading">
          <Loader :size="40" />
        </div>
        <DiscussionItem
          v-for="discussion in discussions"
          :key="discussion"
          :discussion="discussion"
          @on-delete-discussion="onDeleteDiscussion($event)"
        />
      </div>
      <div
        class="col-span-12 lg:col-span-3 hidden lg:flex lg:d-flex h-64 lg:h-96 sm:p-0 lg:p-6"
      >
        <img
          src="https://raw.githubusercontent.com/kosalvireak/Seavphov-Web/refs/heads/vue/assets/Poster-2.jpg"
          class="w-full h-full"
        />
      </div>
    </div>
  </section>
</template>

<script>
import { MDBInput } from "mdb-vue-ui-kit";
import AdsContainer from "../components/discussion/AdsContainer.vue";
import AddDiscussionContainer from "../components/discussion/AddDiscussionContainer.vue";
import DiscussionItem from "../components/discussion/DiscussionItem.vue";
import DiscussionController from "../controllers/DiscussionController";
export default {
  name: "Discussion",
  components: {
    DiscussionItem,
    AddDiscussionContainer,
    AdsContainer,
    MDBInput,
  },
  data() {
    return {
      filters: {},
      keyword: "",
      discussions: [],
      isLoading: false,
    };
  },
  methods: {
    async fetchDiscussions() {
      this.discussions = [];
      this.isLoading = true;
      this.filters.title = this.keyword;
      const response = await DiscussionController.getDiscussionsWithFilter(
        this.filters
      );
      this.isLoading = false;
      this.discussions = response;
    },
    onDeleteDiscussion(id) {
      this.discussions = this.discussions.filter(
        (discussion) => discussion.id !== id
      );
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
