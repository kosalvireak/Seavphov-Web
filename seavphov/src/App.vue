<script>
import { RouterView } from "vue-router";
export default {
  name: "app",
  components: { RouterView },
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
  height: 100vh;
  max-width: var(--max-width);
  background-color: aqua;
}
</style>
