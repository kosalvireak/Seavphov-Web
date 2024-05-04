<template>
  <nav
    v-if="hideNavbar"
    class="AdminNav navbar navbar-expand-md bg-seavphov-light p-0 w-100"
  >
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div
      class="collapse navbar-collapse d-flex justify-content-end"
      id="navbarSupportedContent"
    >
      <ul
        class="navbar-nav my-0 NavUserInfo justify-content-end align-items-center"
        style="--bs-scroll-height: 100px"
      >
        <li class="nav-item me-2 me-lg-1 cursor-pointer">
          <a
            class="nav-link d-flex align-items-sm-center"
            @click="
              () => {
                this.$router.push('/profile');
              }
            "
          >
            <img
              :src="this.$store.state.user.picture"
              class="rounded-circle navbar_img border border-3"
              alt="Black and White Portrait of a Man"
              loading="lazy"
            />
            <strong
              class="ms-1 username d-flex align-items-center justify-contents-center"
              >{{ this.$store.state.user.name }}</strong
            >
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item me-2 d-flex align-items-sm-center">
          <a class="nav-link" @click="Logout()">
            <span><i class="fa-solid fa-right-from-bracket fa-xl"></i></span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: "AdminNav",
  methods: {
    async Logout() {
      await this.$store.dispatch("logoutUser");
      this.$router.push("/login");
    },
  },
  computed: {
    hideNavbar() {
      // if (
      //   this.$route.name == "login" ||
      //   this.$route.name == "signup" ||
      //   this.$route.name == "admin"
      // ) {
      //   return false;
      // } else {
      //   return true;
      // }
      return true;
    },
  },
};
</script>

<style scoped>
.navbar_img {
  height: 38px;
  width: 38px;
  object-fit: cover;
}
.navbar-brand {
  display: none;
}

.SeachInput {
  min-width: 20rem;
  order: -1;
  margin-bottom: 0px;
}
.navbar-brand-center {
  order: 1;
}
.NavUserInfo {
  min-width: 20rem;
  width: fit-content;
  order: 2;
}

.ChatDropdown {
  left: -342px;
}
.NotificationDropdown {
  left: -360px;
}
@media (max-width: 768px) {
  .navbar-brand {
    display: block;
  }
  .navbar-brand-center {
    display: none;
  }
  .SeachInput {
    width: 100%;
    order: -1;
    margin-bottom: 8px;
  }
  .NavUserInfo {
    width: 100%;
    flex-direction: row;
    justify-content: space-evenly !important;
  }
  .ChatDropdown {
    left: -220px;
  }
  .NotificationDropdown {
    left: -330px;
  }
}

@media (max-width: 576px) {
  .NotificationDropdown {
    left: -285px;
  }
}
</style>