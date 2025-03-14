<template>
  <section class="HomeNavigation container-xl flex flex-row h-14 space-x-6">
    <router-link
      :to="{ name: 'home' }"
      class="flex items-center clickable text-sp-primary"
    >
      <i class="fa-solid fa-house fa-md mr-2"></i>
      Home
    </router-link>
    <router-link
      :to="{ name: 'discussion' }"
      class="flex items-center clickable text-sp-primary border-b-2 border-sp-primary"
    >
      <i class="fa-solid fa-message fa-md mr-2"></i>
      Discussion
    </router-link>
    <router-link
      :to="{ name: 'community' }"
      class="flex items-center clickable text-sp-primary"
    >
      <i class="fa-solid fa-user-group fa-md mr-2"></i>
      Community
    </router-link>
    <br />
    <hr />
  </section>
</template>

<script>
export default {
  name: "HomeNavigation",
};
</script>

<style></style>
