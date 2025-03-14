<template>
  <section
    class="HomeNavigation container flex flex-row h-14 space-x-4 border-b-2 border-red-400"
  >
    <router-link
      :to="{ name: 'home' }"
      class="flex items-center clickable text-sp-primary"
    >
      <i class="fa-solid fa-house fa-xl"></i>
      Home
    </router-link>
    <router-link
      :to="{ name: 'discussion' }"
      class="flex items-center clickable text-sp-primary"
    >
      <i class="fa-solid fa-message fa-xl"></i>
      Discussion
    </router-link>
    <router-link
      :to="{ name: 'community' }"
      class="flex items-center clickable text-sp-primary"
    >
      <i class="fa-solid fa-user-group fa-xl"></i>
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

<style>
</style>