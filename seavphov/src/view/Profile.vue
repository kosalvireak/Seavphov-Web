<template>
  <div class="Profile box h-100 w-100 mt-8 p-0">
    <div v-if="isLogin" class="box b-1 p-0 space-y-4">
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
    <div
      v-else
      class="d-flex align-items-center justify-content-center flex-column"
    >
      <NoLoggin />
    </div>
  </div>
</template>

<script>
import ProfileDetail from "../components/profile/ProfileDetail.vue";
import ProfileNavigation from "../components/profile/ProfileNavigation.vue";
import UserMainProfile from "../components/profile/UserMainProfile.vue";
import NoLoggin from "../components/NoLoggin.vue";
import ProfileController from "../controllers/ProfileController";
export default {
  name: "Profile",
  components: {
    UserMainProfile,
    NoLoggin,
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
      this.User = await ProfileController.getMyProfileInfo();
      this.isLoadingProfile = false;
    },
    onSelectNavigation(navigation) {
      this.currentPage = navigation;
    },
  },
};
</script>
