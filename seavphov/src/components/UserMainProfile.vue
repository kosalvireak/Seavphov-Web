<template>
  <div class="UserMainProfile">
    <div
      class="container-sm cover_container w-1800 b-1 p-0"
      style="height: 250px"
    >
      <img
        src="/img/cover.jpg?url"
        class="w-100 h-100 cover_image b-1 rounded-7"
        style="object-fit: cover"
        alt="profile cover"
      />
    </div>
    <div class="container-sm flex user_info b-1">
      <div class="flex user_info_left">
        <img
          :src="profilePicture"
          alt="profile image"
          class="profile_image shadow rounded-circle"
        />
        <div class="profile_name username">
          <h3>{{ username }}</h3>
          <p>{{ email }}</p>
          <p>+16629967189</p>
        </div>
      </div>
      <div class="flex user_info_right">
        <div class="flex profile_socialmedia">
          <SocialMediaList />
          <a
            v-if="fromProfile"
            class="mx-3 text-gray cursor-pointer"
            @click="
              () => {
                this.$router.push({ path: '/edit-profile' });
              }
            "
          >
            <i class="fas fa-pencil fa-xl"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SocialMediaList from "./SocialMediaList.vue";
export default {
  name: "UserMainProfile",
  components: { SocialMediaList },
  props: {
    user: { type: Object, required: true },
    fromProfile: { type: Boolean, required: true },
  },
  computed: {
    username() {
      console.log("username", this.$store.state.user.name);
      return this.$store.state.user.name;
    },
    profilePicture() {
      return this.$store.state.user.picture;
    },
    email() {
      return this.$store.state.user.email;
    },
  },
};
</script>

<style  scoped>
.flex {
  display: flex;
  align-items: center;
  justify-content: center;
}
.cover_image {
  object-fit: cover;
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
    top: 0;
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

@media only screen and (max-width: 576px) {
  .cover_container {
    width: 31.25rem;
  }

  .user_info {
    width: 31.25rem;
  }

  .user_info_left {
    flex-direction: column;
  }

  .icon {
    width: 35px;
    height: 35px;
  }
}
</style>