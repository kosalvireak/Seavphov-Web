<script>
import { RouterView } from "vue-router";
export default {
  name: "AuthLayout",
  components: { RouterView },
};
</script>

<template>
  <div class="AuthLayout w-100 flex-center">
    <RouterView />
  </div>
</template>

<style scoped></style>
