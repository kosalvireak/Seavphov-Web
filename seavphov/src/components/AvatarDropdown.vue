<template>
  <Dropdown
    id="user-profile-dropdown"
    id_content="user-profile-dropdown_content"
    placement="bottom-end"
  >
    <template #button>
      <img
        class="sp-logo-sm rounded-full ring-1 ring-gray-300"
        :src="$store.state.user.picture"
        alt="User Profile"
    /></template>
    <template #content>
      <ul class="py-2 mt-0 w-fit">
        <li>
          <p :class="dropdownItemClass" @click="toRouteName('profile')">
            My profile
          </p>
        </li>
        <li>
          <p :class="dropdownItemClass" @click="toRouteName('edit-profile')">
            Profile settings
          </p>
        </li>
        <li>
          <p :class="dropdownItemClass" @click="logout()">Logout</p>
        </li>
      </ul>
    </template>
  </Dropdown>
</template>

<script>
export default {
  name: "AvatarDropdown",
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
