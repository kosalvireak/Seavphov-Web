<script>
import { RouterView } from "vue-router";
export default {
  name: "AuthLayout",
  components: { RouterView },
};
</script>

<template>
  <div class="AuthLayout">
    <RouterView />
  </div>
</template>

<style scoped>
.AuthLayout {
  margin-top: var(--navbar-height);
}

@media (max-width: 640px) {
  /*medium*/
  .AuthLayout {
    margin-top: var(--navbar-height-mobile);
  }
}
</style>
