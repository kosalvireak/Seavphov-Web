<template>
  <nav v-if="hideNavbar" class="navbar navbar-expand-md bg-seavphov p-0 w-100">
    <div class="container-xxl">
      <a
        class="navbar-brand"
        @click="
          () => {
            this.$router.push('/home');
          }
        "
        ><img
          src="/img/book-logo.png"
          alt="book logo"
          srcset=""
          class="img-fluid"
          style="height: 45px"
      /></a>
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
        class="collapse navbar-collapse d-flex justify-content-between"
        id="navbarSupportedContent"
      >
        <ul
          class="navbar-nav my-0 NavUserInfo justify-content-end"
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
          <li
            v-if="isAdmin"
            class="nav-item me-2 d-flex align-items-sm-center cursor-pointer"
          >
            <a
              class="nav-link"
              @click="
                () => {
                  this.$router.push('/admin');
                }
              "
            >
              <span><i class="fas fa-unlock fa-xl"></i></span>
              <strong class="ms-1">Admin</strong>
            </a>
          </li>
          <li
            v-if="isLogin"
            class="nav-item me-2 d-flex align-items-sm-center cursor-pointer"
          >
            <a
              class="nav-link"
              @click="
                () => {
                  this.$router.push('/book/new');
                }
              "
            >
              <span><i class="fas fa-plus-circle fa-xl"></i></span>
            </a>
          </li>

          <!-- Notification dropdown -->
          <li
            v-if="isLogin"
            class="nav-item dropdown me-3 d-flex align-items-sm-center cursor-pointer"
          >
            <a
              class="nav-link dropdown-toggle hidden-arrow"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              @click="checkDropdownVisibility"
            >
              <i class="fas fa-bell fa-xl"></i>
              <span class="badge rounded-pill badge-notification bg-danger"
                >12</span
              >
            </a>
            <ul class="dropdown-menu NotificationDropdown" style="width: 400px">
              <NotificationDropdown :isShow="isDropdownVisible" />
            </ul>
          </li>
          <!-- Notification dropdown -->

          <!-- Logout -->
          <li class="nav-item me-2 d-flex align-items-sm-center">
            <a class="nav-link" @click="Logout()">
              <span><i class="fa-solid fa-right-from-bracket fa-xl"></i></span>
            </a>
          </li>
        </ul>
        <a
          class="navbar-brand-center cursor-pointer"
          @click="
            () => {
              this.$router.push('/home');
            }
          "
          ><img
            src="/img/book-logo.png"
            alt="book logo"
            srcset=""
            class="img-fluid"
            style="height: 45px"
        /></a>
        <div class="SeachInput">
          <SearchInput class="d-flex" role="search" />
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import NotificationDropdown from "./NotificationDropdown.vue";
import SearchInput from "./SearchInput.vue";
export default {
  name: "Nav",
  components: { NotificationDropdown, SearchInput },
  data() {
    return {
      isDropdownVisible: false,
    };
  },
  methods: {
    async Logout() {
      await this.$store.dispatch("logoutUser");
      this.$router.push("/login");
    },
    checkDropdownVisibility() {
      this.isDropdownVisible = !this.isDropdownVisible;
      console.log("checkDropdownVisibility", this.isDropdownVisible);
    },
  },
  computed: {
    isLogin() {
      return this.$store.getters.isLogin;
    },
    isAdmin() {
      if (this.$store.getters.isLogin) {
        return this.$store.state.user.uuid == "b8WbMnM7C9C9rN5e9fXwDpJ4bC3lZh";
      }
    },
    hideNavbar() {
      if (this.$route.name) {
        if (
          this.$route.name == "login" ||
          this.$route.name == "signup" ||
          this.$route.name == "forgot-password" ||
          this.$route.name.startsWith("admin")
        ) {
          return false;
        } else {
          return true;
        }
      }
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