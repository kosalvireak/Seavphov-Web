<template>
  <section class="CommunityHome container-xl grid grid-cols-12 gap-8">
    <div v-if="isLoading" class="h-96 col-span-12 flex-center">
      <Loader :size="30" />
    </div>

    <template v-else>
      <div class="ProfileInfo col-span-12 lg:col-span-3">
        <CommunityHomeProfile
          :community="community"
          :permissionObject="permissionObject"
        />
      </div>

      <div class="Content col-span-12 lg:col-span-9 space-y-8">
        <CommunityHomeBanner
          :bannerUrl="community.banner"
          :isCopAdmin="permissionObject.isCopAdmin"
        />
        <ReadingChallengeEntry v-if="permissionObject.isCopAdmin" />
        <ReadingChallengeList
          v-if="permissionObject.ableToViewHome"
          :route="route"
        />
      </div>
    </template>
  </section>
</template>

<script>
import ReadingChallengeList from "../../components/community/challenge/ReadingChallengeList.vue";
import ReadingChallengeEntry from "../../components/community/challenge/ReadingChallengeEntry.vue";
import CommunityHomeProfile from "../../components/community/home/CommunityHomeProfile.vue";
import CommunityController from "../../controllers/CommunityController";
import CommunityHomeBanner from "../../components/community/home/CommunityHomeBanner.vue";
export default {
  name: "CommunityHome",
  components: {
    CommunityHomeProfile,
    ReadingChallengeEntry,
    CommunityHomeBanner,
    ReadingChallengeList,
  },
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
