<template>
  <FwbDropdown align-to-end close-inside>
    <template #trigger>
      <FwbAvatar :img="$store.state.user.picture" rounded size="md" />
    </template>
    <nav :class="fwbDropdownNavCss">
      <p :class="fwbDropdownItemCss" @click="toRouteName('profile')">
        My profile
      </p>
      <p :class="fwbDropdownItemCss" @click="toRouteName('profile-setting')">
        Profile settings
      </p>
      <p :class="fwbDropdownItemCss" @click="logout()">Logout</p>
    </nav>
  </FwbDropdown>
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
