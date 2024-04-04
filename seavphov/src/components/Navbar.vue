<template>
  <nav class="navbar navbar-expand-md bg-seavphov p-0">
    <div class="container-fluid">
      <a
        class="navbar-brand"
        @click="
          () => {
            this.$router.push('/home');
          }
        "
        ><img
          src="/img/book.png"
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
          <li class="nav-item me-2 me-lg-1">
            <a
              class="nav-link d-flex align-items-sm-center"
              @click="
                () => {
                  this.$router.push('/profile');
                }
              "
            >
              <img
                :src="this.$store.state.loginUser.profile"
                class="rounded-circle navbar_img border border-3"
                alt="Black and White Portrait of a Man"
                loading="lazy"
              />
              <strong
                class="ms-1 username d-flex align-items-center justify-contents-center"
                >{{ this.$store.state.loginUser.name }}</strong
              >
            </a>
          </li>
          <li class="nav-item me-2 d-flex align-items-sm-center">
            <a
              class="nav-link"
              @click="
                () => {
                  this.$router.push('/newbook');
                }
              "
            >
              <span><i class="fas fa-plus-circle fa-xl"></i></span>
            </a>
          </li>
          <!-- Chat dropdown -->
          <li class="nav-item dropdown me-2 d-flex align-items-sm-center">
            <a
              class="nav-link dropdown-toggle hidden-arrow"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="fas fa-comments fa-xl"></i>

              <span class="badge rounded-pill badge-notification bg-danger"
                >2</span
              >
            </a>
            <ul class="dropdown-menu ChatDropdown">
              <ChatDropdown />
            </ul>
          </li>

          <!-- Notification dropdown -->
          <li class="nav-item dropdown me-3 d-flex align-items-sm-center">
            <a
              class="nav-link dropdown-toggle hidden-arrow"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="fas fa-bell fa-xl"></i>
              <span class="badge rounded-pill badge-notification bg-danger"
                >12</span
              >
            </a>
            <ul class="dropdown-menu NotificationDropdown">
              <NotificationDropdown />
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
          class="navbar-brand-center"
          @click="
            () => {
              this.$router.push('/home');
            }
          "
          ><img
            src="/img/book.png"
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
import ChatDropdown from "./ChatDropdown.vue";
import NotificationDropdown from "./NotificationDropdown.vue";
import SearchInput from "./SearchInput.vue";
export default {
  name: "Navbar",
  components: { ChatDropdown, NotificationDropdown, SearchInput },
  methods: {
    Logout() {
      this.$router.push("/login");
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