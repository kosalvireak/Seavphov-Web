<template>
  <nav class="UserNavbar bg-seavphov w-full py-1">
    <div
      class="container-xl flex flex-wrap items-center justify-between mx-auto px-2"
    >
      <router-link
        :to="{ name: 'home' }"
        class="w-32 flex items-center clickable"
      >
        <img :src="logoUrl" class="sp-logo-md" alt="Seavphov Logo" />
      </router-link>

      <div
        class="w-32 flex items-center md:order-2 space-x-5 rtl:space-x-reverse"
      >
        <template v-if="isLogin">
          <router-link
            :to="{ name: 'add-book' }"
            class="d-flex align-items-sm-center clickable text-white"
          >
            <i class="fas fa-plus-circle fa-xl"></i>
          </router-link>

          <i
            class="fas fa-bell fa-xl text-white clickable"
            @click="openSidebar = true"
          ></i>

          <AvatarDropdown />
        </template>
        <template v-else>
          <FwbButton
            @click="toRouteName('signup')"
            gradient="green"
            class="m-0 px-2 text-xs w-fit"
            >Register</FwbButton
          >
        </template>
        <button
          data-collapse-toggle="navbar-user"
          type="button"
          class="inline-flex items-center p-2 w-10 h-10 text-sm text-white rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          aria-controls="navbar-user"
          aria-expanded="false"
        >
          <span class="sr-only">Open main menu</span>
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15"
            />
          </svg>
        </button>
      </div>
      <div
        class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
        id="navbar-user"
      >
        <div class="flex-center my-2">
          <SearchInput role="search" />
        </div>
      </div>
    </div>
    <NotificationSideBar v-model="openSidebar" />
  </nav>
</template>

<script>
import SearchInput from "./home/SearchInput.vue";
import AvatarDropdown from "./AvatarDropdown.vue";
import NavDropdown from "./common/NavDropdown.vue";
import echo from "../services/websocket/echo";
import NotificationSideBar from "./notification/NotificationSideBar.vue";
export default {
  name: "UserNavbar",
  components: {
    SearchInput,
    AvatarDropdown,
    NavDropdown,
    NotificationSideBar,
  },
  data() {
    return {
      logoUrl: Seavphov.logoUrl,
      notificationCount: 0,
      openSidebar: false,
    };
  },
  mounted() {
    echo.channel("notification").listen("MessageSent", (event) => {
      this.notificationCount += 1;
    });
  },
};
</script>

<style scoped>
/* @media screen and (min-width: 768px) {
  .UserNavbar {
    padding-top: 0px !important;
    padding-bottom: 0px !important;
  }
} */
</style>
