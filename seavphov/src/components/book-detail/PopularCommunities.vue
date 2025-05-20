<template>
  <div class="PopularCommunities mt-5 space-y-4">
    <p class="h3">Our Communities</p>
    <!-- from code it a random -->
    <div class="grid grid-cols-12 gap-4 flex-wrap">
      <PopularCommunityItem
        v-for="community in communities"
        :community="community"
        :key="community.id"
      />
    </div>
  </div>
</template>

<script>
import PopularCommunityItem from "./PopularCommunityItem.vue";
import CommunityController from "../../controllers/CommunityController";
export default {
  name: "PopularCommunities",
  components: { PopularCommunityItem },
  data() {
    return {
      communities: [],
    };
  },
  async mounted() {
    this.communities = await CommunityController.getPopularCommunities();
  },
};
</script>

<style>
</style>