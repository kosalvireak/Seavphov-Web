<template>
  <p class="text-gray-400 text-sm" :class="cssClass">
    <i class="fa fa-info-circle mr-1" aria-hidden="true"></i>{{ text }}
  </p>
</template>

<script>
export default {
  name: "Info",
  props: {
    text: String,
    noSpace: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    cssClass() {
      return this.noSpace ? "my-1" : "my-1";
    },
  },
};
</script>

<style>
</style>