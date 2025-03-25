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
    margin: {
      type: Boolean,
      default: true,
    },
    center: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    cssClass() {
      return this.space + " " + this.position;
    },
    space() {
      return this.margin ? "my-1" : "";
    },
    position() {
      return this.center ? "text-center" : "";
    },
  },
};
</script>

<style>
</style>