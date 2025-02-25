<script>
export default {
  name: "LoadingButton",
  props: {
    isLoading: Boolean,
    type: String,
    text: String,
    disabled: Boolean,
    color: {
      type: String,
      default: "primary",
    },
  },
  computed: {
    backgroundColor() {
      if (this.color == "primary") return "--sp-primary";
      if (this.color == "danger") return "--sp-danger";
      if (this.color == "gray") return "--sp-gray";
    },
    shouldDisabled() {
      return this.isLoading || this.disabled;
    },
  },
};
</script>

<template>
  <button
    :type="type"
    :disabled="shouldDisabled"
    class="min-h-9 btn btn-primary flex-center sp-btn-loading"
    :style="{ 'background-color': 'var(' + backgroundColor + ')' }"
  >
    <span v-if="!isLoading">{{ text }}</span>
    <Loader v-else :size="15" :Color="'#FFFFFF'" />
  </button>
</template>

<style scoped>
.sp-btn-loading {
  background-color: #5c836e;
  color: #ffffff;
}
</style>
