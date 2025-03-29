<template>
  <section class="CommunityHome container-xl grid grid-cols-12 gap-8">
    <div v-if="isLoading" class="h-96 col-span-12 flex-center">
      <Loader :size="30" />
    </div>

    <template v-else>
      <CommunityHomeProfile
        :community="community"
        :permissionObject="permissionObject"
      />
      <div class="Content col-span-12 lg:col-span-9">
        <div class="Banner card h-64 p-2">
          <img
            :src="community.banner"
            class="w-full h-full object-center rounded-lg"
            alt="community banner"
          />
        </div>
      </div>
    </template>
  </section>
</template>

<script>
import CommunityHomeProfile from "../components/community/CommunityHomeProfile.vue";
import CommunityController from "../controllers/CommunityController";
export default {
  name: "CommunityHome",
  components: { CommunityHomeProfile },
  props: {
    permissionObject: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      route: this.$route.params.route,
      community: {},
      isLoading: false,
    };
  },
  async mounted() {
    await this.getCommunityByRoute();
  },
  computed: {},
  methods: {
    async getCommunityByRoute() {
      this.isLoading = true;
      let params = new URLSearchParams();
      params.append("route", this.route);
      this.community = await CommunityController.getCommunityByRoute(
        this.route
      );

      this.isLoading = false;
    },
  },
};
</script>

<style></style>
