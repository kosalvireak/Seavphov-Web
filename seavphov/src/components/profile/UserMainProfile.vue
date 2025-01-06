<template>
  <div class="UserMainProfile">
    <div
      v-if="loading"
      class="h-100 w-100 d-flex align-items-center justify-content-center"
      style="height: 400px !important"
    >
      <Loader />
    </div>
    <div v-else>
      <div
        class="container-sm cover_container w-1800 b-1 p-0"
        @click="handleClick"
      >
        <img
          :src="banner.image_url"
          class="w-100 h-100 b-1 rounded-7 img-fluid cover_img"
          style="object-fit: cover; max-height: 250px"
          :alt="banner.title"
        />
      </div>
      <div class="container-sm flex user_info b-1">
        <div class="flex user_info_left">
          <img
            v-if="user.picture"
            :src="user.picture"
            alt="profile image"
            class="profile_image shadow rounded-circle"
          />
          <div class="profile_name username">
            <h3 class="font-100">{{ user.name }}</h3>
            <p v-if="fromProfile" class="font-75">{{ user.email }}</p>
            <p class="font-75">{{ user.phone }}</p>
          </div>
        </div>
        <div class="flex user_info_right">
          <div class="flex profile_socialmedia">
            <SocialMediaList
              :facebook="user.facebook"
              :instagram="user.instagram"
              :telegram="user.telegram"
              :twitter="user.twitter"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SocialMediaList from "../SocialMediaList.vue";

export default {
  name: "UserMainProfile",
  components: { SocialMediaList },
  props: {
    user: { type: Object, required: true },
    fromProfile: { type: Boolean, required: true },
    loading: { type: Boolean, required: false },
  },
  data() {
    return {
      banner: {},
    };
  },
  methods: {
    async getBanner() {
      this.banner = await this.$store.dispatch("getBanner");
    },
    handleClick() {
      window.open(this.banner.link_url);
    },
  },
  mounted() {
    this.getBanner();
  },
};
</script>

<style scoped>
.flex {
  display: flex;
  align-items: center;
  justify-content: center;
}

.user_info {
  justify-content: space-between !important;
  flex-direction: row;
  flex-wrap: wrap;
  /* width: 1610px; */
  height: 250px;
  position: relative;
  top: -60px;
}

.user_info_left {
  flex-direction: row;
  height: inherit;
}

.profile_image {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border: 9px solid white;
}

.profile_name {
  margin-left: 30px;
  margin-top: 45px;
  font-weight: bolder;
}

.user_info_right {
  flex-direction: row;
  height: inherit;
}

.profile_socialmedia {
  align-items: baseline !important;
  flex-direction: row;
  height: 60px;
  margin-top: 54px;
}

.icon {
  width: 50px;
  height: 50px;
}

.book_options {
  justify-content: space-between !important;
  flex-direction: row;
  height: 50px;
  padding: 0px;
  margin-top: -54px;
}

a:link {
  text-decoration: none;
}

@media only screen and (max-width: 991.98px) {
  .user_info {
    position: relative;
    top: -60px;
    margin-top: 1.5rem;
  }

  .profile_image {
    width: 150px;
    height: 150px;
  }

  .profile_name {
    margin-top: 0px;
  }

  .profile_socialmedia {
    margin-top: 0px;
  }

  .user_info_left {
    height: 150px;
    width: 100%;
    justify-content: space-evenly !important;
  }

  .user_info_right {
    height: 60px;
    width: 100%;
  }
}

@media (max-width: 768px) {
  .cover_img {
    object-fit: contain !important;
  }
  .user_info {
    top: 0px;
  }
}

@media only screen and (max-width: 576px) {
  .user_info {
    height: 300px;
    top: -60px;
  }

  .user_info_left {
    flex-direction: column;
    height: 240px;
  }

  .profile_image {
    width: 100px;
    height: 100px;
  }

  .icon {
    width: 35px;
    height: 35px;
  }

  .profile_name {
    margin-left: 0px;
    margin-top: 0px;
    font-weight: bolder;
  }

  .font-75 {
    font-size: 75%;
  }
  .font-100 {
    font-size: 100%;
  }
}
</style>
