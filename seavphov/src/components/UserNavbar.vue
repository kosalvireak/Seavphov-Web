<template>
  <nav class="bg-seavphov w-full">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
      <a @click="toRouteName('home')" class="flex items-center clickable">
        <img :src="logoUrl" class="sp-logo-md" alt="Seavphov Logo" />
      </a>
      <div class="flex items-center md:order-2 space-x-5 rtl:space-x-reverse">
        <NavDropdown class="position-absolute right-2" />
        <template v-if="isLogin">
          <div
            class="d-flex align-items-sm-center clickable text-white"
            @click="toRouteName('add-book')"
          >
            <i class="fas fa-plus-circle fa-xl"></i>
          </div>
          <Dropdown
            id="notification-dropdown"
            id_content="notification-dropdown_content"
            cssContent="sp-top-4 "
          >
            <template #button>
              <i class="fas fa-bell fa-2xl text-white"></i
            ></template>
            <template #content><NotificationDropdown /> </template>
          </Dropdown>
          <AvatarDropdown />
        </template>
        <template v-else>
          <FwbButton
            @click="toRouteName('signup')"
            gradient="green"
            class="m-0 px-2 text-xs w-fit"
            >Signup</FwbButton
          >
        </template>
        <button
          data-collapse-toggle="navbar-user"
          type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
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
  </nav>
</template>

<script>
import SearchInput from "./home/SearchInput.vue";
import AvatarDropdown from "./AvatarDropdown.vue";
import NotificationDropdown from "./home/NotificationDropdown.vue";
import NavDropdown from "./common/NavDropdown.vue";
export default {
  name: "UserNavbar",
  components: {
    SearchInput,
    AvatarDropdown,
    NotificationDropdown,
    NavDropdown,
  },
};
</script>

<style scoped></style>
