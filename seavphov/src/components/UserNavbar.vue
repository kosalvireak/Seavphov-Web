<template>
  <nav class="bg-seavphov w-full">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
      <a @click="toRouteName('home')" class="flex items-center cursor-pointer">
        <img :src="$logoUrl" class="sp-logo-md" alt="Seavphov Logo" />
      </a>
      <div class="flex items-center md:order-2 space-x-5 rtl:space-x-reverse">
        <div
          class="d-flex align-items-sm-center cursor-pointer"
          @click="toRouteName('add-book')"
        >
          <i class="fas fa-plus-circle fa-xl"></i>
        </div>
        <Dropdown
          id="notification-dropdown"
          id2="notification-dropdown2"
          cssContent="sp-top-4"
        >
          <template #button> <i class="fas fa-bell fa-2xl"></i></template>
          <template #content><NotificationDropdown /> </template>
        </Dropdown>
        <AvatarDropdown :imgUrl="$store.state.user.picture1" />
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
        <ul
          class="flex flex-col font-medium my-2 md:p-0 border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:bg-gray-800 dark:border-gray-700"
        >
          <SearchInput class="d-flex" role="search" />
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import SearchInput from "./SearchInput.vue";
import Dropdown from "./Dropdown.vue";
import AvatarDropdown from "./AvatarDropdown.vue";
import NotificationDropdown from "./home/NotificationDropdown.vue";
export default {
  name: "UserNavbar",
  components: { SearchInput, AvatarDropdown, Dropdown, NotificationDropdown },
};
</script>

<style scoped>
</style>