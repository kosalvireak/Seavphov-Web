<template>
  <section
    class="AdminNavbar w-full h-navbar flex align-items-center justify-content-end bg-sp-tertiary"
  >
    <AvatarDropdown
      class="me-8"
      name="admin"
      imgUrl="https://images.booksense.com/images/129/860/9798889860129.jpg"
    />
  </section>
</template>

<script>
import AvatarDropdown from "../AvatarDropdown.vue";
export default {
  name: "AdminNavbar",
  components: { AvatarDropdown },
};
</script>

<style>
</style>