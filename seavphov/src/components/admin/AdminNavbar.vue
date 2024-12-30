<template>
  <section
    class="AdminNavbar w-full h-navbar flex align-items-center justify-content-end bg-sp-tertiary"
  >
    <AvatarDropdown class="me-8" />
  </section>
</template>

<script>
import AvatarDropdown from "../common/AvatarDropdown.vue";
export default {
  name: "AdminNavbar",
  components: { AvatarDropdown },
};
</script>

<style>
</style>