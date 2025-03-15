<template>
  <section class="CommunityHome mt-8 container-xl grid grid-cols-12 gap-8">
    <div
      class="ProfileInfo card col-span-12 lg:col-span-3 flex flex-center py-6"
    >
      <div
        class="Profile w-24 h-24 lg:w-40 lg:h-40 rounded-full border-2 border-gray-300 flex-center"
      >
        <img
          :src="community.profile"
          class="object-contain border-2 border-gray-300"
          alt="profile"
        />
      </div>
      <p class="h4">{{ community.name }}</p>
      <p class="text-sm p-2 text-center">
        {{ community.description }}
      </p>
      <p>Created on: {{ formatDate(community.created_at) }}</p>
    </div>
    <div class="Content col-span-12 lg:col-span-9">
      <div class="Banner card h-64 p-2">
        <img
          :src="community.banner"
          class="w-full h-full object-center rounded-lg"
          alt="community banner"
        />
      </div>
    </div>
  </section>
</template>

<script>
import CommunityController from "../controllers/CommunityController";
export default {
  name: "CommunityHome",
  data() {
    return {
      route: this.$route.params.route,
      community: {
        // id: 1,
        // name: "Love me",
        // route: "love-me",
        // profile:
        //   "https://static.vecteezy.com/system/resources/previews/054/453/530/non_2x/proactive-community-engagement-icon-vector.jpg",
        // banner:
        //   "https://charitysmith.org/wp-content/uploads/2023/09/community.webp",
        // description:
        //   "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sit amet volutpat dolor. Sed suscipit lobortis efficitur. Morbi ultricies eleifend mi. Vivamus nunc libero, tristique at malesuada vel, luctus vitae dolor. Nam pharetra scelerisque enim, feugiat rhoncus lacus semper eget. Vestibulum ipsum ipsum, ornare nec maximus quis, scelerisque in turpis. Maecenas dictum, ipsum in facilisis ultrices, augue mi pharetra sapien, quis rutrum ligula urna non magna. Phasellus blandit, augue in venenatis laoreet, libero lacus lobortis augue, sit amet fringilla sapien nunc eu dui. Curabitur pellentesque massa a erat pellentesque laoreet. Phasellus finibus urna sed ante sodales, ac condimentum lacus pellentesque.",
        // private: false,
        // created_at: "2025-03-05T13:52:20.000000Z",
        // updated_at: "2025-03-05T13:52:20.000000Z",
      },
    };
  },
  async mounted() {
    await this.fetchCommunity();
  },
  methods: {
    async fetchCommunity() {
      let params = new URLSearchParams();
      params.append("route", this.route);
      this.community = await CommunityController.getCommunityByRoute(
        this.route
      );
    },
  },
};
</script>

<style>
</style>