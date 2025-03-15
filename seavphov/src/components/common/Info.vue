<template>
  <p class="text-gray-400 text-sm mt-1 mb-0">
    <i class="fa fa-info-circle mr-1" aria-hidden="true"></i>{{ text }}
  </p>
</template>

<script>
export default {
  name: "Info",
  props: ["text"],
};
</script>

<style>
</style>