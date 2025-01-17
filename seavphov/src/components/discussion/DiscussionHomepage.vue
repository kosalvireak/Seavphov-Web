<template>
  <section class="DiscussionHomepage w-100 flex-center">
    <div
      class="sp-bg-secondary w-50 d-flex flex-column justify-content-center align-items-center rounded-xl"
    >
      <span class="text-xl font-bold">Enjoying what you see?</span>
      <span class="text-black-400 mb-3"
        >Join the discussion and share your thoughts with our vibrant
        community!</span
      >
      <FwbButton @click="toRouteName('discussion')" color="green"
        >Go to Discussion</FwbButton
      >
    </div>
  </section>
</template>

<script>
export default {
  name: "DiscussionHomepage",
};
</script>

<style scoped>
.sp-bg-secondary {
  background-color: #faecc9;
  height: 200px;
}
</style>