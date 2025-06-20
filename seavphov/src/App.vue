<script>
import { RouterView } from "vue-router";
export default {
  name: "app",
  components: { RouterView },
  mounted() {
    window.Echo.channel("create-asset").listen(".CreateAsset", (e) => {
      Seavphov.toast.info("New " + e.message + " has been added.");
    });
  },
  unmounted() {
    window.Echo.leave("create-asset");
  },
};
</script>

<template>
  <div class="app flex-center">
    <RouterView />
  </div>
</template>

<style scoped>
.app {
  width: 100%;
  height: 100%;
  /* max-width: var(--max-width); */
}
</style>
