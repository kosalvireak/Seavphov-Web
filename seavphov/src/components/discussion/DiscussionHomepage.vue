<template>
  <section class="DiscussionHomepage w-100 flex-center">
    <div
      class="sp-bg-secondary container-xl d-flex flex-column justify-content-center align-items-center rounded-xl space-y-4"
    >
      <span class="text-xl font-bold">Enjoying what you see?</span>
      <span class="text-black-400 mb-2"
        >Join the discussion forum and share your thoughts with our vibrant
        community!</span
      >
      <LoadingButton color="green"
        ><router-link :to="{ name: 'discussion' }" class="text-white">
          Go to Discussion
        </router-link></LoadingButton
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
