<template>
  <div class="Profile box h-100 w-100 mt-8">
    <div class="container-sm box b-1 p-0 space-y-4">
      <UserMainProfile
        :fromProfile="false"
        :user="User"
        :loading="isLoadingProfile"
      />
      <ViewProfileNavigation @onSelectNavigation="onSelectNavigation" />
      <ProfileDetail :page="currentPage" />
    </div>
  </div>
</template>

<script>
import ProfileDetail from "../components/profile/ProfileDetail.vue";
import RenderBook from "../components/RenderBook.vue";
import UserMainProfile from "../components/profile/UserMainProfile.vue";
import NoLoggin from "../components/NoLoggin.vue";
import ViewProfileNavigation from "../components/profile/ViewProfileNavigation.vue";
import ProfileController from "../controllers/ProfileController";
export default {
  name: "ViewProfile",
  components: {
    UserMainProfile,
    RenderBook,
    NoLoggin,
    ViewProfileNavigation,
    ProfileDetail,
  },
  data() {
    return {
      currentPage: "books",
      isLoadingProfile: false,
      User: {},
    };
  },
  async mounted() {
    const uuid = this.$route.params.uuid;
    this.fetchOtherUserProfile(uuid);
  },
  methods: {
    async fetchOtherUserProfile(uuid) {
      this.isLoadingProfile = true;
      this.User = await ProfileController.fetchOtherUserProfile(uuid);
      this.isLoadingProfile = false;
    },
    onSelectNavigation(navigation) {
      this.currentPage = navigation;
    },
  },
};
</script>

<style scoped>
</style>
