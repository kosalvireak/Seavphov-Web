<template>
  <section class="CommunityAdmin w-100 h-100 container-xl">
    <div v-if="isCheckingPermission" class="h-96 col-span-12 flex-center">
      <Loader :size="30" />
    </div>
    <div v-else>
      <EditCopProfile :route="route" />
      <AddReadingChallenge />
    </div>
  </section>
</template>

<script>
import CopMemberController from "../../../controllers/CopMemberController";
import AddReadingChallenge from "../admin/AddReadingChallenge.vue";
import EditCopProfile from "../admin/EditCopProfile.vue";
export default {
  name: "CommunityAdmin",
  components: { AddReadingChallenge, EditCopProfile },
  data() {
    return {
      isLoading: false,
      route: this.$route.params.route,
      isCheckingPermission: true,
    };
  },
  async mounted() {
    // Check Permission
    await this.checkViewPermission();
  },
  methods: {
    async checkViewPermission() {
      this.isCheckingPermission = true;
      const response = await CopMemberController.checkViewCopHomePermission(
        this.route
      );

      if (!response.isCopAdmin) {
        this.toRouteName("not-found");
      } else {
        this.isCheckingPermission = false;
      }
    },
  },
};
</script>

<style></style>
