<template>
  <Dropdown id="user-profile-dropdown" id2="user-profile-dropdown2">
    <template #button>
      <img
        class="sp-logo-md rounded-full ring-1 ring-gray-300"
        :src="imgUrl"
        alt="User Profile"
    /></template>
    <template #content>
      <ul class="py-2 mt-0 w-28" :aria-labelledby="id">
        <li>
          <p :class="dropdownItemCss" @click="toRouteName('profile')">
            Profile
          </p>
        </li>
        <li>
          <p :class="dropdownItemCss" @click="logout()">Logout</p>
        </li>
      </ul>
    </template>
  </Dropdown>
</template>

<script >
import Dropdown from "./Dropdown.vue";
export default {
  name: "AvatarDropdown",
  components: { Dropdown },
  props: {
    name: String,
    imgUrl: String,
    id: String,
    id2: String,
  },
  computed: {
    dropdownItemCss() {
      return "block px-4 py-2 mb-0 w-100 text-sm text-center text-gray-700 hover:bg-gray-100 cursor-pointer";
    },
  },
};
</script>

<style scoped>
:deep(.px-4) {
  /* original style px-3 */
  padding-right: 1rem !important;
  padding-left: 1rem !important;
}
:deep(.bg-blue-700) {
  background-color: var(--sp-primary);
}
</style>