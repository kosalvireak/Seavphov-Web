<script>
export default {
  name: "LoadingButton",
  props: { isLoading: Boolean, type: String, text: String, disabled: Boolean },
};
</script>

<template>
  <button
    :type="type"
    :disabled="isLoading || disabled"
    class="btn btn-primary flex-center sp-btn-loading"
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
