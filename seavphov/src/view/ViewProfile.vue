<template>
  <div class="Profile box h-100 w-100 mt-8">
    <div class="container-xl box b-1 p-0 space-y-4">
      <UserMainProfile
        :viewMyProfile="false"
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
import UserController from "../controllers/UserController";
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
    this.getOtherUserProfile(uuid);
  },
  methods: {
    async getOtherUserProfile(uuid) {
      this.isLoadingProfile = true;
      this.User = await UserController.getOtherProfile(uuid);
      this.isLoadingProfile = false;
    },
    onSelectNavigation(navigation) {
      this.currentPage = navigation;
    },
  },
};
</script>

<style scoped></style>
