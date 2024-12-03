<template>
  <div class="flex justify-center space-x-2 cursor-pointer">
    <fwb-avatar :img="imgUrl" rounded />
    <fwb-dropdown :text="name">
      <fwb-list-group class="w-auto m-0 p-0">
        <fwb-list-group-item
          class="hover:bg-gray-200"
          @click="toRouteName('profile')"
        >
          Profile
        </fwb-list-group-item>
        <fwb-list-group-item class="hover:bg-gray-200" @click="logout()">
          Logout
        </fwb-list-group-item>
      </fwb-list-group>
    </fwb-dropdown>
  </div>
</template>

<script >
import {
  FwbAvatar,
  FwbDropdown,
  FwbListGroup,
  FwbListGroupItem,
} from "flowbite-vue";
export default {
  name: "AvatarDropdown",
  components: { FwbAvatar, FwbDropdown, FwbListGroup, FwbListGroupItem },
  props: {
    name: String,
    imgUrl: String,
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