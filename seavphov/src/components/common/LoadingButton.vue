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
      if (this.color == "yellow") return "--sp-yellow";
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
    :class="{ '!cursor-not-allowed': shouldDisabled }"
    class="min-h-9 btn btn-primary flex-center sp-btn-loading"
    :style="{ 'background-color': 'var(' + backgroundColor + ')' }"
  >
    <slot v-if="!isLoading">
      <span>{{ text }}</span>
    </slot>
    <TinyLoader v-else :size="15" :Color="'#FFFFFF'" />
  </button>
</template>

<style scoped>
.sp-btn-loading {
  background-color: #5c836e;
  color: #ffffff;
}
</style>
