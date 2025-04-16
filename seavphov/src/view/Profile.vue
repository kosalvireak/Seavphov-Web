<template>
  <div class="Profile box h-100 w-100 mt-8 p-0">
    <div class="box b-1 p-0 space-y-4">
      <UserMainProfile
        :fromProfile="true"
        :user="User"
        :loading="isLoadingProfile"
      />
      <ProfileNavigation
        @onSelectNavigation="onSelectNavigation"
        :uuid="User.uuid"
      />
      <ProfileDetail :page="currentPage" />
    </div>
  </div>
</template>

<script>
import ProfileDetail from "../components/profile/ProfileDetail.vue";
import ProfileNavigation from "../components/profile/ProfileNavigation.vue";
import UserMainProfile from "../components/profile/UserMainProfile.vue";
import UserController from "../controllers/UserController";
export default {
  name: "Profile",
  components: {
    UserMainProfile,
    ProfileNavigation,
    ProfileDetail,
  },
  data() {
    return {
      User: {},
      currentPage: "my-books",
      isLoadingProfile: false,
    };
  },
  async mounted() {
    this.getProfile();
  },
  methods: {
    async getProfile() {
      this.isLoadingProfile = true;
      this.User = await UserController.getProfile();
      this.isLoadingProfile = false;
    },
    onSelectNavigation(navigation) {
      this.currentPage = navigation;
    },
  },
};
</script>
