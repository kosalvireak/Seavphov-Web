<script>
import { RouterView } from "vue-router";
export default {
  name: "UserLayout",
  components: { RouterView },
};
</script>

<template>
  <div class="UserLayout">
    <RouterView />
  </div>
</template>

<style scoped>
.UserLayout {
  margin-top: var(--navbar-height);
}

@media (max-width: 640px) {
  /*medium*/
  .UserLayout {
    margin-top: var(--navbar-height-mobile);
  }
}
</style>
