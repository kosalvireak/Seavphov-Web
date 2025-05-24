<template>
  <div class="UserMainProfile">
    <div
      v-if="loading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader />
    </div>
    <template v-else>
      <div class="container-xl h-fit relative space-y-4">
        <div class="CoverSection h-40 lg:h-72 mb-[-76px] lg:mb-0">
          <img
            :src="getUserCoverImage"
            class="w-100 h-100 b-1 rounded-7 img-fluid object-cover"
            alt="user's cover"
          />
        </div>
        <div
          class="ProfileSection group relative h-fit flex items-center justify-between flex-col lg:flex-row space-y-4 space-x-0 lg:space-y-0 lg:space-x-4"
        >
          <!-- Edit profile Pencil Icon -->
          <div
            v-if="viewMyProfile"
            class="hidden group-hover:block clickable absolute right-2 top-2"
            @click="toRouteName('edit-profile')"
          >
            <i class="fa fa-pencil fa-xl text-gray-800" aria-hidden="true"></i>
          </div>

          <!-- Edit profile Pencil Icon -->
          <div class="ProfileImage h-32 w-32 lg:h-40 lg:w-40 flex-shrink-0">
            <img
              v-if="user.picture"
              :src="user.picture"
              alt="profile image"
              class="w-100 h-100 img-fluid object-cover shadow rounded-circle ring-1 ring-gray-300"
            />
          </div>
          <div
            class="ProfileInfo flex items-center lg:items-start text-center flex-col w-100 !space-y-2"
          >
            <p class="text-2xl font-bold">{{ user.name }}</p>
            <p v-if="viewMyProfile" class="text-base">{{ user.email }}</p>
            <p v-if="inValidProperty(user, 'phone')" class="text-base">
              {{ user.phone }}
            </p>
            <p v-if="inValidProperty(user, 'bio')" class="text-base">
              {{ user.bio }}
            </p>
          </div>
          <div class="ProfileSocialMedia flex-shrink-0">
            <SocialMediaList
              :facebook="user.facebook"
              :instagram="user.instagram"
              :telegram="user.telegram"
              :twitter="user.twitter"
            />
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import SocialMediaList from "../SocialMediaList.vue";

export default {
  name: "UserMainProfile",
  components: { SocialMediaList },
  props: {
    user: { type: Object, required: true },
    viewMyProfile: { type: Boolean, required: true },
    loading: { type: Boolean, required: false },
  },
  computed: {
    getUserCoverImage() {
      if (this.user?.cover && this.user.cover !== "null") {
        return this.user.cover;
      } else {
        return "https://flowbite.com/docs/images/examples/image-3@2x.jpg";
      }
    },
  },
};
</script>

<style scoped></style>
